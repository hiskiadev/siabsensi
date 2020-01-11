<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AbsentTeachers;
use App\Models\Teachers;
use App\Repositories\LogBackendRepository;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Artisan;

class AbsentTeachersController extends Controller
{
	public function getList(){
		$data['page_title'] 	  = 'List Absensi Guru / Karyawan';

		if (g('date')) {
			$date = dt(g('date'));
			$data['data'] = Teachers::simpleQuery()
			->where('weekdays','like','%'.$date->format('l').'%')
			->select('id','code','name')
			->get();
		}else{
			$date = now();
			$data['data'] = Teachers::simpleQuery()
			->where('weekdays','like','%'.$date->format('l').'%')
			->select('id','code','name')
			->get();
		}

		foreach ($data['data'] as $key => $row) {
			$absent = AbsentTeachers::simpleQuery()
			->where('teachers_id',$row->id)
			->whereDate('date',$date->format('Y-m-d'))
			->first();

			if ($absent) {
				$row->time_in = $absent->time_in;
				$row->type 	  = $absent->type;
				$row->photo   = $absent->photo;
			}else{
				$row->time_in = NULL;
				$row->type 	  = 'Belum Absen';
				$row->photo   = NULL;
			}
		}

		$data['date'] = $date->format('m/d/Y');
		$data['page_description'] = 'Absensi Tanggal '.$date->format('d F Y');

		return view('absent.teachers.list',$data);
	}

	public function postAdd(Request $request){
		$data = Teachers::findByCode(g('code'));

		$schedule = Teachers::simpleQuery()
		->where('code',g('code'))
		->where('weekdays','like','%'.dt(g('add-date'))->format('l').'%')
		->first();

		if (!$schedule) {
			return redirect()->back()->with(['message_type' => 'error', 'message' => 'Tidak Ada Jadwal Pada Saat Itu!']);
		}

		$check = AbsentTeachers::simpleQuery()
		->where('teachers_id',$data->getId())
		->whereDate('date',dateDb(g('add-date')))
		->first();

		if ($check) {
			$update = AbsentTeachers::simpleQuery()
			->where('teachers_id',$data->getId())
			->whereDate('date',dateDb(g('add-date')));

			if ($request->hasFile('photo')) {
				$image = $request->file('photo');
				$image_name = time().uniqid().'.'.$image->getClientOriginalExtension();
				$destinationPath = public_path('data/absent/'.date('Y').'/'.date('m'));
				$image->move($destinationPath, $image_name);

				$result_image = 'data/absent/'.date('Y').'/'.date('m').'/'.$image_name;
			}else{
				$result_image = NULL;
			}

			if (g('add-type') == 'Tepat Waktu') {
				$update->update([
					'time_in' => now()->format('H:i:s'),
					'is_out' => NULL,
					'type' => g('add-type'),
					'photo' => NULL
				]);
			}elseif (g('add-type') == 'Terlambat') {
				$update->update([
					'time_in' => now()->format('H:i:s'),
					'is_out' => NULL,
					'type' => g('add-type'),
					'photo' => NULL
				]);
			}else{
				$update->update([
					'time_in' => NULL,
					'is_out' => NULL,
					'type' => g('add-type'),
					'photo' => $result_image
				]);
			}

		}else{
			$new = New AbsentTeachers;
			$new->setDate(dateDb(g('add-date')));
			$new->setTeachersId($data->getId());
			$new->setType(g('add-type'));
			$new->setIsOut(NULL);

			if ($request->hasFile('photo')) {
				$image = $request->file('photo');
				$image_name = time().uniqid().'.'.$image->getClientOriginalExtension();
				$destinationPath = public_path('data/absent/'.date('Y').'/'.date('m'));
				$image->move($destinationPath, $image_name);

				$result_image = 'data/absent/'.date('Y').'/'.date('m').'/'.$image_name;
				$new->setPhoto($result_image);
			}

			if (g('add-type') == 'Tepat Waktu') {
				$new->setTimeIn(now()->format('H:i:s'));
				$new->setPhoto(NULL);
			}elseif (g('add-type') == 'Terlambat') {
				$new->setTimeIn(now()->format('H:i:s'));
				$new->setPhoto(NULL);
			}else{
				$new->setTimeIn(NULL);
			}

			$new->save();
		}

		$log['action'] = 'Create';
		$log['page'] = 'List Absensi Guru / Karyawan';
		$log['description'] = 'Menambahkan Absen Guru / Karyawan '.$data->getName().' Dengan Status: '.g('add-type');
		LogBackendRepository::add($log);

		return redirect()->back()->with(['message_type' => 'success', 'message' => 'Data Berhasil Disimpan!']);
	}

	public function getAlpa(){
		Artisan::call('set:alpa --type=teachers');

		if (substr(Artisan::output(), 6, 2) == 'is') {
			return redirect()->back()->with(['message_type' => 'error', 'message' => 'Tidak Ada Yang Ditandai!']);
		}

		$log['action'] = 'Create';
		$log['page'] = 'List Absent Guru / Karyawan';
		$log['description'] = 'Menandai Absen Guru / Karyawan Yang Alpa';
		LogBackendRepository::add($log);

		return redirect()->back()->with(['message_type' => 'success', 'message' => 'Berhasil Menandai Guru / Karyawan Yang Alpa!']);
	}

	public function getBolos(){
		Artisan::call('set:bolos --type=teachers');

		if (substr(Artisan::output(), 6, 2) == 'is') {
			return redirect()->back()->with(['message_type' => 'error', 'message' => 'Tidak Ada Yang Ditandai!']);
		}

		$log['action'] = 'Create';
		$log['page'] = 'List Absent Guru / Karyawan';
		$log['description'] = 'Menandai Absen Guru / Karyawan Yang Bolos';
		LogBackendRepository::add($log);

		return redirect()->back()->with(['message_type' => 'success', 'message' => 'Berhasil Menandai Guru / Karyawan Yang Bolos!']);
	}

	public function getCalendar(){
		$data['page_title'] 	  = 'Absensi Kehadiran Guru / Karyawan';
		$data['page_description'] = 'Kalenderisasi Absensi Guru / Karyawan';
		$data['sidebar_type'] 	  = 'mini-sidebar';

		$data['all_month'] 		  = AbsentTeachers::simpleQuery()->get()
		->groupBy(function($d){
			return dt($d->created_at)->format('m');
		});

		$data['all_year']		  = AbsentTeachers::simpleQuery()->get()
		->groupBy(function($d){
			return dt($d->created_at)->format('Y');
		});

		$data['teachers'] 	  = Teachers::simpleQuery()
		->orderBy('code','asc')
		->get();

		if (g('year')) {
			$data['dates'] = allDates(g('year'),g('month'));
		}else{
			$data['dates'] = allDates();
		}

		return view('absent.teachers.calendar', $data);
	}
}