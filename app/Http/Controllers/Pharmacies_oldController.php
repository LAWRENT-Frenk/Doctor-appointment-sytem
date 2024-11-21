<?php

    namespace App\Http\Controllers;

    use App\Models\Pharmacy;
    use App\Models\Doctor;
    use App\Models\Patient;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;

    class PharmaciesController extends Controller
    {
        /**
         * Display a listing of the hospital pharmacy.
         *
         * @return \Illuminate\Http\Response
         */
        public function index()
        {
            // $pharmacies = Pharmacy::all();
            $pharmacies = Pharmacy::paginate(11);
            $doctors = Doctor::all();
            $patients = Patient::all();
            return view('pharmacies.index', compact('pharmacies', 'patients' , 'doctors'));
        }

        /**
         * Show the form for creating a new appointment.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
            $doctors = Doctor::all();
            $patients = Patient::all();
            return view('pharmacies.create', compact('doctors', 'patients'));
        }
        

        /**
         * Store a newly created hospital pharmacy in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'patient_id' => 'required|exists:patients,id',
            'contact' => 'required|string',
            'medicine' => 'required|string',
            'amount' => 'required|numeric', // Ensure amount is numeric
            'description' => 'required|string',
            'doctor_id' => 'required|exists:doctors,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Pharmacy::create($request->all());

        return redirect()->route('pharmacies.index')->with('success', 'Hospital Pharmacy created successfully.');
    }

        /**
         * Display the specified appointment.
         *
         * @param  \App\Models\Pharmacy  $pharmacy
         * @return \Illuminate\Http\Response
         */
        public function show(Pharmacy $pharmacy)
        {
            return view('pharmacies.show', compact('pharmacy'));
        }

        /**
         * Show the form for editing the specified Pharmacy.
         *
         * @param  \App\Models\Pharmacy  $pharmacy
         * @return \Illuminate\Http\Response
         */
        public function edit(Pharmacy $pharmacy)
        {
            $pharmacies = Pharmacy::all();
            return view('pharmacies.edit', compact('pharmacies', 'doctors', 'patients'));
        }

        /**
         * Update the specified pharmacy in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \App\Models\Pharmacy  $pharmacy
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, Pharmacy $pharmacy)
        {
            $validator = Validator::make($request->all(), [
                'patient_id' => 'required|exists:patients,id',
                'contact' => 'required|string',
                'medicine' => 'required|string',
                'amount' => 'required|numeric', // Ensure amount is numeric
                'description' => 'required|string',
                'doctor_id' => 'required|exists:doctors,id',
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
    
            Pharmacy::create($request->all());
    
            return redirect()->route('pharmacies.index')->with('success', 'Hospital Pharmacy created successfully.');
        }

        /**
         * Remove the specified pharmacy from storage.
         *
         * @param  \App\Models\Pharmacy  $pharmacy
         * @return \Illuminate\Http\Response
         */
        public function destroy(Pharmacy $pharmacy)
        {
            $pharmacy->delete();
            return redirect()->route('pharmacies.index')->with('success', 'Hospital Pharmacy deleted successfully.');
        }
    }
