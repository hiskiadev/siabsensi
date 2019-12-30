<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teachers;
use App\Repositories\LogBackendRepository;
use Session;
use Validator;
use Excel;
use File;
use App\Imports\TeachersImport;

class TeachersController extends Controller
{
	public function getIndex(){
		$data['page_title'] = 'Data Guru';
		$data['page_description'] = 'Kumpulan Data Guru SMK Wikrama 1 Jepara';
		// $data['sidebar_type'] = "mini-sidebar";
		$data['data'] = Teachers::findAllByIsTeacher(1);

		return view('teachers.index',$data);
	}

	public function getAdd(){
		$data['page_title'] = 'Tambah Data Guru';
		$data['page_description'] = 'Silahkan Isi Form Berikut Dengan Benar & Tepat';

		$subjects = Teachers::simpleQuery()
		->select('subjects')
		->groupBy('subjects')
		->get();

		$arr_subjects = [];
		foreach ($subjects as $key => $row) {
			$arr_subjects[] = $row->subjects;
		}
		$data['subjects'] = implode('","', $arr_subjects);

		return view('teachers.form',$data);
	}

	public function postAdd(Request $request){
		$new = New Teachers;
		$new->setCode($request->code);
		$new->setName(ucwords(strtolower($request->name)));
		$new->setSubjects($request->subjects);
		$new->setPosition($request->position);
		$new->setIsTeacher(1);

		$address['city'] = ucwords(strtolower($request['city']));
		$address['district'] = ucwords(strtolower($request['district']));
		$address['village'] = ucwords(strtolower($request['village']));
		$address['rt'] = $request['rt'];
		$address['rw'] = $request['rw'];

		$new->setAddress(json_encode($address));
		$new->save();

		$log['action'] = 'Create';
		$log['page'] = 'Data Guru';
		$log['description'] = 'Menambahkan Data Guru Baru: '.$request->name;
		LogBackendRepository::add($log);

		return redirect('teachers')->with(['message_type' => 'success', 'message' => 'Data Berhasil Disimpan!']);
	}

	public function getEdit($id){
		$data['page_title'] = 'Tambah Data Guru';
		$data['page_description'] = 'Silahkan Isi Form Berikut Dengan Benar & Tepat';
		$data['data'] = Teachers::findById($id);
		$data['address'] = json_decode($data['data']->getAddress());
		$subjects = Teachers::simpleQuery()
		->select('subjects')
		->groupBy('subjects')
		->get();

		$arr_subjects = [];
		foreach ($subjects as $key => $row) {
			$arr_subjects[] = $row->subjects;
		}
		$data['subjects'] = implode('","', $arr_subjects);
		return view('teachers.form',$data);
	}

	public function postEdit(Request $request, $id){
		$edit = Teachers::findById($id);
		$edit->setCode($request->code);
		$edit->setName(ucwords(strtolower($request->name)));
		$edit->setSubjects($request->subjects);
		$edit->setPosition($request->position);

		$address['city'] = ucwords(strtolower($request['city']));
		$address['district'] = ucwords(strtolower($request['district']));
		$address['village'] = ucwords(strtolower($request['village']));
		$address['rt'] = $request['rt'];
		$address['rw'] = $request['rw'];

		$edit->setAddress(json_encode($address));
		$edit->save();

		$log['action'] = 'Update';
		$log['page'] = 'Data Guru';
		$log['description'] = 'Mengedit Data Guru: '.$request->name;
		LogBackendRepository::add($log);

		return redirect('teachers')->with(['message_type' => 'info', 'message' => 'Data Berhasil Diupdate!']);
	}

	public function getDelete($id){
		$data = Teachers::findById($id);

		$log['action'] = 'Delete';
		$log['page'] = 'Data Guru';
		$log['description'] = 'Menghapus Data Guru: '.$data->getName();
		LogBackendRepository::add($log);

		$data->delete();

		return redirect()->back()->with(['message_type' => 'success', 'message' => 'Data Berhasil Dihapus!']);
	}

	public function getDetail($id){
		$data['page_title'] = 'Detail Guru';
		$data['data'] = Teachers::findById($id);
		$data['address'] = json_decode($data['data']->getAddress());
		$data['qrcode'] = json_encode([
            'code' => nisencrypt($data['data']->getCode()),
            'type' => 'teacher'
        ]);

		return view('teachers.detail', $data);
	}

	public function postExport(Request $request){
		$extension = File::extension($request->file('file_export')->getClientOriginalName());
		if($extension == "xlsx" || $extension == "xls"){
			$save = Excel::import(new TeachersImport, $request->file('file_export'));
			if($save){
				$log['action'] = 'Create';
				$log['page'] = 'Data Guru';
				$log['description'] = 'Mengimport Data Guru Baru';
				LogBackendRepository::add($log);

				return redirect()->back()->with(['message_type' => 'info', 'message' => 'Berhasil Mengimport Data!']);
			}else{
				return redirect()->back()->with(['message_type' => 'error', 'message' => 'Failed!']);
			}
		}else {
			return redirect()->back()->with(['message_type' => 'info', 'message' => 'Extensi Harus .xls Atau .xlxs!']);
		}
	}
}
