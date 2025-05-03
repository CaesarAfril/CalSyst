<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Machine;
use App\Models\Plant;
use App\Models\Validation_asset;
use Illuminate\Http\Request;
use App\Mail\EarlyWarningMail;
use Illuminate\Support\Facades\Mail;

class Validation_assetController extends Controller
{
    public function index()
    {
        $assets = Validation_asset::with([
            'department',
            'plant'
        ])->get();

        $machine = Machine::all();

        $plant = Plant::all();
        $department = Department::all();
        return view('asset.validation_asset', [
            'assets' => $assets,
            'departments' => $department,
            'plants' => $plant,
            'machines' => $machine,
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'asset_department' => 'required|string|exists:department,uuid',
            'asset_plant' => 'required|string|exists:plant,uuid',
            'asset_location' => 'required|string|max:255',
            'asset_machine_name' => 'required|string|max:255',
            'asset_detail' => 'required|string|max:255'
        ];

        $validated = $request->validate($rules);

        Validation_asset::create([
            'plant_uuid' => $validated['asset_plant'],
            'dept_uuid' => $validated['asset_department'],
            'location' => $validated['asset_location'],
            'machine_uuid' => $validated['asset_machine_name'],
            'detail' => $validated['asset_detail']
        ]);

        return redirect()->back();
    }

    public function destroy($id)
    {
        $asset = Validation_asset::findOrFail($id);
        $asset->delete();
        return redirect()->back();
    }

    public function importCsv(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt'
        ]);

        $file = fopen($request->file('csv_file'), 'r');
        $header = fgetcsv($file);

        $file = fopen($request->file('csv_file'), 'r');
        $header = fgetcsv($file, 0, ';');

        while ($row = fgetcsv($file, 0, ';')) {
            $data = array_combine($header, $row);
            $plant = Plant::where('plant', $data['plant'])->firstOrFail();
            $department = Department::where('department', $data['departemen'])->firstOrFail();
            dd($department);
            $machine = Machine::where('machine_name', $data['mesin'])->firstOrFail();

            Validation_asset::create([
                'plant_uuid' => $plant->uuid,
                'dept_uuid' => $department->uuid,
                'location' => $data['lokasi'],
                'machine_uuid' => $machine->uuid,
                'detail' => $data['detail'],
                'type' => $data['tipe'],
            ]);
        }

        fclose($file);
        return back()->with('success', 'Import CSV berhasil');
    }

    public function sendEarlyWarning(Request $request)
    {
        $data = $request->validate([
            'machine_name' => 'required|string|max:255',
        ]);

        $this->sendEmails(
            ['engineering@example.com', 'department@example.com', 'cikande@example.com'],
            new EarlyWarningMail($data['machine_name'])
        );

        return redirect()->back()->with('success', 'Early Warning 1 email has been sent.');
    }

    public function sendEarlyWarning2(Request $request)
    {
        $data = $request->validate([
            'test_alat' => 'required|string|max:255',
            'test_mesin' => 'required|string|max:255',
        ]);

        $this->sendEmails(
            ['engineering@example.com', 'department@example.com', 'cikande@example.com'],
            new \App\Mail\EarlyWarning2Mail($data['test_alat'], $data['test_mesin'])
        );

        return redirect()->back()->with('success', 'Early Warning 2 email has been sent.');
    }

    private function sendEmails(array $recipients, $mailable)
    {
        foreach ($recipients as $email) {
            Mail::to($email)->send($mailable);
        }
    }

}