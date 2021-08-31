<?php

namespace App\Http\Controllers;
use App;
use Illuminate\Http\Request;
use App\Calc\Decider;
use App\Calc\DemandFactory;

class CalcController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function show(Request $request)
    {
        return view(
            'index',
            [
                'content' => var_export($request->input(), true)
            ]
        );
    }

    public function calc(Request $request)
    {
        $demand = DemandFactory::makeDemand($request->input());

        if ($demand->hasErrors()) {
            return response()->json([
                'status' => 'fail',
                'errors' => $demand->getErrors(),
            ]);
        }

        $decider = new Decider($demand);

        $decider->addTest(function($demand){
            return $demand->getAge() < 18 ? 5 : 0;
        });

        $decider->addTest(function($demand){
            if ($demand->getAge() <= 30) return 0;
            if ($demand->getGender() != 1) return 0;
            if ($demand->getSalary() >= 25000) return 0;
            if ($demand->getEngagement() != 0) return 0;
            if ($demand->getInfants() != 0) return 0;

            return 2;
        });

        $decider->addTest(function($demand){
            if ($demand->getAge() <= 30) return 0;
            if ($demand->getGender() != 1) return 0;
            if ($demand->getSalary() >= 30000) return 0;
            if ($demand->getEngagement() != 0) return 0;
            if ($demand->getInfants() == 0) return 0;

            return 3;
        });

        $decider->addTest(function($demand){
            if ($demand->getAge() <= 26) return 0;
            if ($demand->getGender() != 0) return 0;
            if ($demand->getSalary() >= 22000) return 0;
            if ($demand->getEngagement() != 0) return 0;
            if ($demand->getInfants() != 0) return 0;

            return 2;
        });

        $decider->addTest(function($demand){
            if ($demand->getAge() <= 26) return 0;
            if ($demand->getGender() != 0) return 0;
            if ($demand->getSalary() >= 28000) return 0;
            if ($demand->getEngagement() != 0) return 0;
            if ($demand->getInfants() <= 2) return 0;

            return 3;
        });

        $decider->addTest(function($demand){
            if ($demand->getAge() <= 65) return 0;
            if (!$demand->getHasDebt()) return 0;
            if ($demand->getEmployment() != 0) return 0;

            return 3;
        });

        $decider->addTest(function($demand){
            if (!$demand->getHasDebt()) return 0;
            if ((($demand->getCurrentDebt()/$demand->getSalary()) * 100) <= .5) return 0;

            return 3;
        });

        $decider->addTest(function($demand){
            if ($demand->getAge() < 18) return 0;
            if ($demand->getSalary() >= 15000) return 0;


            return 2;
        });

        $decider->addTest(function($demand){
            if ($demand->getAge() < 18) return 0;
            if ($demand->getAge() > 35) return 0;
            if ($demand->getInfants() <> 1) return 0;

            return 1;
        });

        $decider->addTest(function($demand){
            if ($demand->getAge() < 18) return 0;
            if ($demand->getAge() > 35) return 0;
            if ($demand->getInfants() <= 1) return 0;

            return 2;
        });

        $decision = $decider->decide();

        return response()->json([
            'status' => $decision ? 'success' : 'fail',
            'weight' => $decider->getWeight(),
            'errors' => null,
        ]);
    }
}
