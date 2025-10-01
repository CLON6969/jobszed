<?php
namespace App\Http\Controllers\User\Applicant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VoluntaryDisclosure;
use Illuminate\Support\Facades\Auth;

class VoluntaryDisclosureController extends Controller
{
    public function edit(VoluntaryDisclosure $voluntary_disclosure)
    {
        $vd = VoluntaryDisclosure::firstOrNew(['user_id'=>Auth::id()]);
        return view('user.applicant.voluntary_disclosures.edit', compact('vd'));
    }

    public function update(Request $r, VoluntaryDisclosure $voluntary_disclosure = null)
    {
        $data = $r->validate([
            'disability_status'=>'required|string',
            'ethnicity'=>'required|string',
            'gender_identity'=>'required|string',
            'is_veteran'=>'required|boolean',
        ]);
        $data['user_id'] = Auth::id();
        VoluntaryDisclosure::updateOrCreate(['user_id'=>Auth::id()], $data);
        return redirect()->route('user.applicant.voluntary_disclosures.edit')->with('success','Disclosure saved.');
    }
}
