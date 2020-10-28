<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\ActionPlanCommon;
use App\Model\ApprovalProcessTrack;
use App\Model\Notification;
use App\Model\DocumentDelete;
use Auth;
use DB;
use App\Model\Role;
use  App\Model\User;
use App\Model\ApprovalChanelPath;
class CommonController extends Controller
{
	public function remove_files(Request $Request)
	{
		$data = $Request->all();
		$rr = base64_decode($data['file_path']);
		if (file_exists($rr)) {
		unlink($rr);
		}
	}
	public function approve_action_plan(Request $Request)
	{
		$data = $Request->all();
		// t($data);
		$info = ActionPlanCommon::where('id', $data['id'])->get(); 
		//add approval track
		$module = str_replace('-','_',$data['module']);
		$submodule = str_replace('-','_',$data['submodule']);
		$add_data['module'] = $module;
		$add_data['type'] = 'action_plan';
		$add_data['type_id'] = $info[0]->id;
		$add_data['initiator_id'] =  $info[0]->created_by;
		$add_data['user_id'] = Auth::user()->id;
		$add_data['remarks'] = $data['comment'];
		$add_data['process_step'] = $info[0]->approval_step;
		$add_data['responsible_person_id'] =$info[0]->responsibility;
		//make dynamic url
		if($module == "project_approval")
			{
				$url = URL("project/project-approval/view-action-plan/".base64_encode($info[0]->id)."/".$submodule);
			}
			else if($module == "land")
			{
				$url = URL("land-management/view-action-plan/".base64_encode($info[0]->id)."/".$submodule);
			}
			else if($module == "litigation")
			{
				
				$url = URL("litigation-management/".$submodule."/view-action-plan/".base64_encode($info[0]->id)."/".$data['encodedid']);
			}
			else
			{
				$url ="#";
			}
		//make dynamic url
		if(isset($data['approve']))
		{
			$status = 'approved';
			$add_data['accept_status'] = $status;
		}
		else if(isset($data['resend']))
		{
			$status = 'resend';
			$add_data['accept_status'] = $status;
		}
		else
		{
			$status = 'rejected';
			$add_data['accept_status'] = $status;
		}
		$add_data['approval_date'] = isset($data['date']) && $data['date']!=''?date('Y-m-d', strtotime(str_replace('/', '-',$data['date']))):null;
		ApprovalProcessTrack::insertGetId($add_data);
		//notification section
		change_notification_status(Auth::user()->id,$module,$submodule ,'approval', $info[0]->id,'action_plan');
		//add noti
		//t($module);
		//t($info[0]->responsibility);
		//t(Auth::user()->id);
		$user_data = User::where('id',$info[0]->responsibility)->get();
		//t($user_data);
		$responsibilityModule = Role::where('fl_archive','N')->where('id',$user_data[0]->role_id)->get();
		//t($responsibilityModule[0]->name);
		$module_name = str_replace(" ","_",strtolower($responsibilityModule[0]->name));
		$next_approver_id = next_approver_id($module_name,$info[0]->responsibility,Auth::user()->id);
		//print_r($next_approver_id);
		//print_r($status);
		//t($module_name);
		//exit();
		if($next_approver_id!='' && $status=='approved')
		{
			
		$notidata['module'] = $module; 
		$notidata['module_type'] =$submodule;
		$notidata['module_sub_type'] ='action_plan';
		$notidata['module_subtype_id'] = $data['id'];
		$notidata['notification_type'] = 'approval';
		$notidata['user_id'] = $next_approver_id;
		$notidata['created_by'] = Auth::user()->id;
		$notidata['notification_text'] = "You received action plan approval request";
		$notidata['notification_url'] = $url; 
		$noti_id = Notification::InsertgetId($notidata);
		}
		else if($next_approver_id =='' && $status=='approved')
		{
			$update_status['approval_status'] = $status;
			ActionPlanCommon::where('id', $data['id'])->update($update_status);
				// notification after final approve //
		$notiUpdatedata['module'] = $module; 
		$notiUpdatedata['module_type'] = $submodule;
		$notidata['module_sub_type'] ='action_plan';
		$notiUpdatedata['module_subtype_id'] = $data['id'];
		$notiUpdatedata['notification_type'] = 'notification';
		$notiUpdatedata['user_id'] = $info[0]->responsibility;
		$notiUpdatedata['created_by'] = Auth::user()->id;
		$notiUpdatedata['notification_text'] = "You assigned as a responsible person to the " . $module. "action plan";
		$notiUpdatedata['notification_url'] =  $url;
		$noti_id = Notification::InsertgetId($notiUpdatedata);
		// notification after final approve //
		}
		else if($status=='rejected')
		{
			$update_status['approval_status'] = $status;
			ActionPlanCommon::where('id', $data['id'])->update($update_status);
		}
		return redirect($url)->with('success-msg', 'Project Status Successfully Changed');
	}
	
	public function delete_request(Request $Request)
	{
		$data = $Request->all();
		//insert doc details
		$doc_id = isset($data['doc_id'])?$data['doc_id']:'';
		$sub_sub_module = isset($data['sub_sub_module'])?$data['sub_sub_module']:'';
		$insert['module'] = $data['module'];
		$insert['sub_module'] =  $data['sub-module'];
		$insert['sub_module_id'] =  $data['sub_module_type_id'];
		$insert['file_name'] =  $data['doc_name'];
		$insert['requested_by'] =  $data['requested_by'];
		$insert['module_link'] =  isset($data['link'])?$data['link']:'';
		if($doc_id!='')
		{
			$insert['document_id'] =  $doc_id;
		}
		if($sub_sub_module!='')
		{
			$insert['sub_sub_module'] =  $sub_sub_module;
		}
		$id = send_delete_request($insert);
		if($id!='')
		{
			echo "delete request successfully send";
		}
		else
		{
			echo "Something erong,please try after some time";
		}
	}
	
	public function all_delete_request(Request $Request)
	{
		 $doc_list = DocumentDelete::where('fl_archive','N')->orderBy('id','desc')->get();
		  $doc_info = array();
		 foreach( $doc_list as $k=>$list)
		 {
			 if( $list->document_id!='')
			 {
				 /* if($list->module=='project approval')
				 {
					  $doc_info = DB::table('prj_aprvl_document_table')->where('id', $list->document_id)->get();
				 } */
				 if($list->module=='land management')
				 {
					  $doc_info = DB::table('all_documents')->where('id', $list->document_id)->get();
				 }
			 }
			 $doc_list[$k]['doc_info'] = $doc_info;
		 }
		// t($doc_info,1);
		 $arrOutputData['doc_list'] = $doc_list;
		 return view('master.document-delete',$arrOutputData);
	}
	
	public function doc_details(Request $Request)
	{
		$data = $Request->all();
		$request_info = DocumentDelete::where('id',$data['request_id'] )->get();
		//t($request_info[0]->module);
		//t($request_info[0]->sub_module);
		//t($request_info[0]->sub_sub_module);
		//exit();
		
		if(count($request_info)>0)
		{
		
		if(($request_info[0]->module=='land management'||$request_info[0]->module=='encumbrance certificate') && $request_info[0]->sub_sub_module != 'actionplan')
		 {
			  $doc_info = DB::table('all_documents')->where('id', $request_info[0]->document_id)->get();
		 }
		 // litigation -> notice-> draft document //
		 if($request_info[0]->module=='litigation' && $request_info[0]->sub_module == 'notice' && $request_info[0]->sub_sub_module == 'draft_notice_document')
		 {
			
			  $doc_info = DB::table('draft_notice_document')->where('id', $request_info[0]->document_id)->get();
			  
		 }
		 
		 if($request_info[0]->module=='litigation' && $request_info[0]->sub_module == 'notice' && $request_info[0]->sub_sub_module == 'final_notice_document')
		 {
			
			  $doc_info = DB::table('final_notice_document')->where('id', $request_info[0]->document_id)->get();
			  
		 }
		 if($request_info[0]->module=='litigation' && ($request_info[0]->sub_module == 'court' || $request_info[0]->sub_module == 'high_court') && $request_info[0]->sub_sub_module == 'document_submitted_in_court')
		 {
			
			  $doc_info = DB::table('litigation_court_document_submission')->where('id', $request_info[0]->document_id)->get();
			  
		 }
		 
		  if($request_info[0]->module=='litigation' && ($request_info[0]->sub_module == 'court' || $request_info[0]->sub_module == 'high_court') && $request_info[0]->sub_sub_module == 'document_submitted_by_op')
		 {
			
			  $doc_info = DB::table('litigation_court_document_received')->where('id', $request_info[0]->document_id)->get();
			  
		 }
		 
		 if($request_info[0]->module=='litigation' && ($request_info[0]->sub_module == 'court' || $request_info[0]->sub_module == 'high_court') && $request_info[0]->sub_sub_module == 'draft_pleading_doc')
		 {
			
			  $doc_info = DB::table('draft_pleading_document')->where('id', $request_info[0]->document_id)->get();
			  
		 }
		 if($request_info[0]->module=='litigation' && ($request_info[0]->sub_module == 'court' || $request_info[0]->sub_module == 'high_court') && $request_info[0]->sub_sub_module == 'final_pleading_doc')
		 {
			
			  $doc_info = DB::table('final_pleading_document')->where('id', $request_info[0]->document_id)->get();
			  
		 }
		 
		 
		}
		
		$url = isset($request_info[0]->module_link) && $request_info[0]->module_link!=''?URL($request_info[0]->module_link):'#';
		
		$html='<table class="internal-table" cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">
		<thead>
		<tr>
		<th>Document Type</th><th>Document Category</th><th>File</th>
		<th>Remarks</th>
		<th>Action</th>
		</tr>
		</thead>
		<tbody>
		';
		$html.='<tr>'; 
		if(isset($doc_info))
		{
			if(count($doc_info)>0)
			{
		 //for project approval
		/*  if(($request_info[0]->module=='project approval') || ($request_info[0]->sub_sub_module == 'actionplan'))
			{
				
				$doc_type = isset($doc_info[0]->doc_type) &&($doc_info[0]->doc_type!='')? $doc_info[0]->doc_type:"";
				$doc_type_id =isset($doc_info[0]->doc_sub_type_id) && $doc_info[0]->doc_sub_type_id!=''?get_module_name_by_id($doc_info[0]->doc_sub_type_id):"N/A";
				$file_name =isset($doc_info[0]->file_name)?$doc_info[0]->file_name:'';
				$remarks ="N/A";
				$html.='<td>'.ucwords(str_replace('_',' ',$doc_type)).'</td>';
				$html.='<td>'.ucwords(str_replace('_',' ',$doc_type_id)).'</td>';
				$html.='<td>'.$file_name.'</td>';
				$html.='<td>'.$remarks.'</td>';
				$html.='<td><a type="button" href="'.$url.'" class="btn btn-xs btn-info" target="_blank">view Details</a></td>';
			} */
			
		if(($request_info[0]->module=='land management'||$request_info[0]->module=='encumbrance certificate') && $request_info[0]->sub_sub_module != 'actionplan')
		 {
			
			 $doc_type = isset($doc_info[0]->doc_type) &&($doc_info[0]->doc_type!='')? get_decumentmaster_type_name_by_id($doc_info[0]->doc_type):"";
			 $doc_category = isset($doc_info[0]->doc_category) && $doc_info[0]->doc_category!=''?$doc_info[0]->doc_category:"";
			 $file_name = isset($doc_info[0]->file_name)?$doc_info[0]->file_name:"";
			 $remarks = isset($doc_info[0]->remarks)?$doc_info[0]->remarks:"";
			 $html.='<td>'.$doc_type.'</td>';
			 $html.='<td>'.$doc_category.'</td>';
			 $html.='<td>'. $file_name.'</td>';
			 $html.='<td>'. $remarks.'</td>';
			 $html.='<td><a type="button" href="'.$url.'" class="btn btn-xs btn-info" target="_blank">view Details</a></td>';
			 
		 }
		  // litigation -> notice-> draft document //
		 if($request_info[0]->module=='litigation' && $request_info[0]->sub_module == 'notice')
			{
				
				$doc_type = isset($doc_info[0]->document_id) && $doc_info[0]->document_id!=''?get_module_name_by_id($doc_info[0]->document_id):"N/A";
				$doc_type_id = " ";
				$file_name =isset($doc_info[0]->file_name)?$doc_info[0]->file_name:'';
				$remarks =" ";
				
				$html.='<td>'.ucwords(str_replace('_',' ',$doc_type)).'</td>';
				$html.='<td>'.ucwords(str_replace('_',' ',$doc_type_id)).'</td>';
				$html.='<td>'.$file_name.'</td>';
				$html.='<td>'.$remarks.'</td>';
				$html.='<td><a type="button" href="'.$url.'" class="btn btn-xs btn-info" target="_blank">view Details</a></td>';
			}
			
			//// litigation -> Court Case-> Document Submit in court  // Document Submitted by op ////
		 if($request_info[0]->module=='litigation' && ($request_info[0]->sub_module == 'court' || $request_info[0]->sub_module == 'high_court') && ($request_info[0]->sub_sub_module == 'document_submitted_in_court' || $request_info[0]->sub_sub_module == 'document_submitted_by_op'))
			{
				$court_doc = json_decode($doc_info[0]->document);
					 foreach($court_doc as $k=> $dc)
					 {
						 if($dc->file_name == $request_info[0]->file_name)
						 {
						$doc_type = isset($dc->document_activity) && $dc->document_activity!=''?$dc->document_activity:"N/A";
						$doc_type_id = " ";
						$file_name =isset($dc->file_name)?$dc->file_name:'';
						$remarks =isset($dc->remarks)?$dc->remarks:'';
						
						$html.='<td>'.ucwords(str_replace('_',' ',$doc_type)).'</td>';
						$html.='<td>'.ucwords(str_replace('_',' ',$doc_type_id)).'</td>';
						$html.='<td>'.$file_name.'</td>';
						$html.='<td>'.$remarks.'</td>';
						$html.='<td><a type="button" href="'.$url.'" class="btn btn-xs btn-info" target="_blank">view Details</a></td>';
						 }
					 }
			}
			
			 if($request_info[0]->module=='litigation' && ($request_info[0]->sub_module == 'court' || $request_info[0]->sub_module == 'high_court') && ($request_info[0]->sub_sub_module == 'draft_pleading_doc' || $request_info[0]->sub_sub_module == 'final_pleading_doc'))
			{
				
				$doc_type = isset($doc_info[0]->pleading_id) && $doc_info[0]->pleading_id!=''?get_module_name_by_id($doc_info[0]->pleading_id):"N/A";
				$doc_type_id = " ";
				$file_name =isset($doc_info[0]->file_name)?$doc_info[0]->file_name:'';
				$remarks =isset($doc_info[0]->remarks)?$doc_info[0]->remarks:'';
				
				$html.='<td>'.ucwords(str_replace('_',' ',$doc_type)).'</td>';
				$html.='<td>'.ucwords(str_replace('_',' ',$doc_type_id)).'</td>';
				$html.='<td>'.$file_name.'</td>';
				$html.='<td>'.$remarks.'</td>';
				$html.='<td><a type="button" href="'.$url.'" class="btn btn-xs btn-info" target="_blank">view Details</a></td>';
			}
		}
		}
		else
		{
			
			if($request_info[0]->sub_module =='family')
			 {
				 $html.='<td>'.ucwords(str_replace('_',' ',$request_info[0]->sub_sub_module)).'</td>';
			 }
			
			 if($request_info[0]->sub_module =='entity')
			 {
				 $html.='<td>Entity Document</td>';
			 }
				 $html.='<td>N/A</td>';
				 $html.='<td>'. $request_info[0]->file_name .'</td>';
				 $html.='<td>N/A</td>';
				 $html.='<td><a type="button" href="'.$url.'" class="btn btn-xs btn-info" target="_blank">view Details</a></td>';
			 
			 
		}
		$html.='</tr>
		</tbody>
		</table>';
		echo $html;
	}
	
	public function delete_documents(Request $Request)
	{
		 $data = $Request->all();
		 //t($data,1);
		 $doc_id = $data['noti_id'];
	
		 foreach($doc_id as $k=>$id)
		 {
			 $request_infos = DocumentDelete::where('fl_archive','N')->where('id',$id)->get();
			 if(count($request_infos )>0)
			 {
				 $request_info = $request_infos[0];
				//action plan				
				if($request_info->sub_sub_module=='actionplan')
					{
						if($request_info->document_id!='')
						{
							
							 DB::table('prj_aprvl_document_table')->where('id',$request_info->document_id)->delete();
						}					
					}
				 //project approval delete
				
				//common land document
			
				 if($request_info->module == 'land management' || $request_info->module == 'encumbrance certificate'|| $request_info->module == 'Site')
				{
					if($request_info->document_id!='')
					{
					 DB::table('all_documents')->where('id',$request_info->document_id)->delete();
					}
				}
				//entity delete
				   if($request_info->module == 'project' && $request_info->sub_module =='entity')
				{ 
					  $entity = DB::table('project_entity')->where('id',$request_info->sub_module_id)->get();
					  $entity_doc = json_decode($entity[0]->document);
					 foreach($entity_doc as $k=> $dc)
					 {
						 if($dc->file_name == $request_info->file_name)
						 {
							 unset ($entity_doc[$k] );
						 }
					 }
					 $update_entity['document'] = json_encode($entity_doc);
					 DB::table('project_entity')->where('id',$request_info->sub_module_id)->update($update_entity);
				}
				//Id proof
				 if($request_info->module == 'land management' && $request_info->sub_sub_module =='ID proof')
				{
				 $update_id_prooft['file_name'] = '';
				 $update_id_prooft['file_path'] = '';
				 $update_id_prooft['file_original_path'] = '';
				 DB::table('id_proof_document')->where('id',$request_info->sub_module_id)->update($update_id_prooft);
				}
				//Aadhar Card
				 if($request_info->module == 'land management' && $request_info->sub_sub_module =='Aadhar Card')
				{
				 $update_adhar['file_name'] = '';
				 $update_adhar['file_path'] = '';
				 $update_adhar['file_original_path'] = '';
				 DB::table('aadhar_card')->where('id',$request_info->sub_module_id)->update($update_adhar);
				}
				//Member Photo
				 if($request_info->module == 'land management' && $request_info->sub_sub_module =='member photo')
				{
				 $update_photo['member_photo'] = '';
				 DB::table('family_tree')->where('id',$request_info->sub_module_id)->update($update_photo);
				}
				//Death Certificate
				 if($request_info->module == 'land management' && $request_info->sub_sub_module =='Death Certificate')
				{
				 $update_dc['file_name'] = '';
				 $update_dc['file_path'] = '';
				 $update_dc['file_original_path'] = '';
				 DB::table('family_death_document')->where('id',$request_info->sub_module_id)->update($update_dc);
				}
				//Cast Certificate
				 if($request_info->module == 'land management' && $request_info->sub_sub_module =='Cast Certificate')
				{
				 $update_dc['file_name'] = '';
				 $update_dc['file_path'] = '';
				 $update_dc['file_original_path'] = '';
				 DB::table('family_caste_certificate')->where('id',$request_info->sub_module_id)->update($update_dc);
				}
				//Pan Document
				 if($request_info->module == 'land management' && $request_info->sub_sub_module =='PAN Document')
				{
				 $update_dc['file_name'] = '';
				 $update_dc['file_path'] = '';
				 $update_dc['file_original_path'] = '';
				 DB::table('pan_document')->where('id',$request_info->sub_module_id)->update($update_dc);
				}
				 // litigation -> notice-> draft document //
				  if($request_info->module=='litigation' && $request_info->sub_module == 'notice' && $request_info->sub_sub_module == 'draft_notice_document')
			     {
				 $update_dc['file_name'] = '';
				 
				 $update_dc['description'] = '';
				 DB::table('draft_notice_document')->where('id',$request_info->sub_module_id)->update($update_dc); 
				 }
				 // litigation -> notice-> final document //
				  if($request_info->module=='litigation' && $request_info->sub_module == 'notice' && $request_info->sub_sub_module == 'final_notice_document')
				{
					 $update_dc['file_name'] = '';
				 
				 $update_dc['description'] = '';
				 DB::table('final_notice_document')->where('id',$request_info->sub_module_id)->update($update_dc); 
			
				}
				 //litigation -> court -> document submit
				   if($request_info->module=='litigation' && ($request_info->sub_module == 'court' || $request_info->sub_module == 'high_court') && $request_info->sub_sub_module == 'document_submitted_in_court')
				{ 
					  
					   $doc_info = DB::table('litigation_court_document_submission')->where('id', $request_info->sub_module_id)->get();
					  
					  $doc_info_arr = json_decode($doc_info[0]->document);
					  $doc_arr = array();
					 foreach($doc_info_arr as $k=> $dc)
					 {
						 if($dc->file_name == $request_info->file_name)
						 {
							 
							 
						 }
						else{
							
							$update_dc['document_activity'] = $dc->document_activity;
						 $update_dc['title'] = $dc->title;
						 $update_dc['remarks'] = $dc->remarks;
						  $update_dc['status'] = $dc->status;		

						 
						 $update_dc['file_path'] = $dc->file_path;
						 $update_dc['file_name'] = $dc->file_name;
						 array_push($doc_arr,$update_dc);
							
						}
					 }
					 $update_entity['document'] = json_encode($doc_arr);
					 DB::table('litigation_court_document_submission')->where('id',$request_info->sub_module_id)->update($update_entity);
				}
				
				//litigation -> court -> document submit by op
				   if($request_info->module=='litigation' && ($request_info->sub_module == 'court' || $request_info->sub_module == 'high_court') && $request_info->sub_sub_module == 'document_submitted_by_op')
				{ 

					   $doc_info = DB::table('litigation_court_document_received')->where('id', $request_info->sub_module_id)->get();
					  
					  $doc_info_arr = json_decode($doc_info[0]->document);
					  $doc_arr = array();
					 foreach($doc_info_arr as $k=> $dc)
					 {
						 if($dc->file_name == $request_info->file_name)
						 {
							 
							 
						 }
						else{
							
							$update_dc['document_activity'] = $dc->document_activity;
						 $update_dc['title'] = $dc->title;
						 $update_dc['remarks'] = $dc->remarks;
						  $update_dc['status'] = $dc->status;		

						 
						 $update_dc['file_path'] = $dc->file_path;
						 $update_dc['file_name'] = $dc->file_name;
						 array_push($doc_arr,$update_dc);
							
						}
					 }
					 $update_entity['document'] = json_encode($doc_arr);
					 DB::table('litigation_court_document_received')->where('id',$request_info->sub_module_id)->update($update_entity);
				}
				 if($request_info->module=='litigation' && ($request_info->sub_module == 'court' || $request_info->sub_module == 'high_court') && $request_info->sub_sub_module == 'draft_pleading_doc')
				 {
					 $update_dc['file_name'] = '';
				 
				 $update_dc['description'] = '';
				 DB::table('draft_pleading_document')->where('id',$request_info->sub_module_id)->update($update_dc); 
				 }
				  if($request_info->module=='litigation' && ($request_info->sub_module == 'court' || $request_info->sub_module == 'high_court') && $request_info->sub_sub_module == 'final_pleading_doc')
				  {
					  $update_dc['file_name'] = '';
				 
				 $update_dc['description'] = '';
				 DB::table('final_pleading_document')->where('id',$request_info->sub_module_id)->update($update_dc); 
				  }
				 
				 
				 
				DocumentDelete::where('fl_archive','N')->where('id',$id)->delete(); 
				return redirect('document/all-delete-request')->with('success-msg', 'Document successfully deleted');
			}
		 }
	}
	public function check_assign_Id_responsible_person(Request $request)
	{
		$data = $request->all();
		
		//t(is_array($data['responsible_person_id']));
		if(isset($data['responsible_person_id']) && $data['responsible_person_id']!='')
		{
		 $arr = array();
		 if (is_array($data['responsible_person_id']))
		 {
			
			
	$a_val = $data['responsible_person_id'] ;

		//t($a_val);
		$appro_val_total = ApprovalChanelPath::select('initiator_id')->where('fl_archive','N')->where('approver_id','!=','')->where('module',$data['module'])->get();
		foreach($appro_val_total as $appro_val_total_val)
		{
			array_push($arr,$appro_val_total_val->initiator_id);
		}
		//t($arr);
		$result=array_diff($a_val,$arr);
        //print_r($result);
		//echo count($result);
		if (empty($result)&& count($result)==0) 
		{
			$message = array("status"=>1,"Msg"=>"Person assigned successfully");
			//echo "empty";
		}else{
			$userdataName= get_user_by_string_id(implode(',',$result));
				
				$message = array("status"=>0,"Msg"=>"Please Set Approval Path for " . $userdataName);
			//echo " not empty";
		}
		
	
			
			
		
		

		 }	
else
{
$approver_details = ApprovalChanelPath::select('approver_id')->where('fl_archive','N')->where('initiator_id',$data['responsible_person_id'])->where('module',$data['module'])->get();
			
			 $approver_id = isset($approver_details[0]->approver_id)?$approver_details[0]->approver_id:'';
			
			if($approver_id == '')
			{
				
				$userdataName= get_user_by_id($data['responsible_person_id']);
				
				$message = array("status"=>0,"Msg"=>"Please Set Approval Path for " . $userdataName);
			
				
				
			}
			else
			{
				
				$message = array("status"=>1,"Msg"=>"Person assigned successfully");
				
			}
}	
		 
		
		
		
		
		 
		}
		else{
			$message = array("status"=>0,"Msg"=>"Please Select Any User ");
		}
		return  $message ;
	}
}
