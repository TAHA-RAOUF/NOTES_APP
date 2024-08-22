<?php

namespace App\Http\Controllers;

use App\Models\NewDirecteur;
use App\Models\NewFormateur;
use App\Models\NewStagiaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    //
    public function login(Request $request)
    {
        // Valider les données du formulaire
        $input = $request->all();

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('directeur')->attempt(['email'=> $input['email'], 'password'=> $input['password']])){
            return redirect()->action([DirecteurController::class, 'pagehome']);
        }elseif (Auth::guard('formateur')->attempt(['email'=> $input['email'], 'password'=> $input['password']])){
            return redirect()->action([FormateurController::class, 'pagehomeF']);
        }elseif (Auth::guard('stagiaire')->attempt(['email'=> $input['email'], 'password'=> $input['password']])){
            return redirect()->action([StagiaireController::class, 'pagehomeS']);
        }else{
            return back() -> with ('error','Email ou mot de passe incorrect');
        }
        


    //     if ($directeur = NewDirecteur::where('email', '=', $request->email)->first()) {

    //         if ($directeur) {
    //             if (Hash::check($request->password, $directeur->password)) {
    //                 Auth::login($directeur);
    //                 return redirect()->action([DirecteurController::class, 'pagehome']);
    //             } else {
    //                 return back()->with('fail', 'password nit match');
    //             }
    //         } else {
    //             return back()->with('fail', 'No account found for this email');
    //         }
    //     } elseif ($formateur = NewFormateur::where('email', '=', $request->email)->first()) {

    //         if ($formateur) {
    //             if (Hash::check($request->password, $formateur->password)) {
    //                 Auth::login($formateur);
    //                 return view('formateur');
    //             } else {
    //                 return back()->with('fail', 'password nit match');
    //             }
    //         } else {
    //             return back()->with('fail', 'No account found for this email');
    //         }
    //     } elseif ($stagiaire = NewStagiaire::where('email', '=', $request->email)->first()) {

    //         if ($stagiaire) {
    //             if (Hash::check($request->password, $stagiaire->password)) {
    //                 Auth::login($stagiaire);
    //                 return view('stagiaire');
    //             } else {
    //                 return back()->with('fail', 'password nit match');
    //             }
    //         } else {
    //             return back()->with('fail', 'No account found for this email');
    //         }
    //     } else {
    //         return back()->with('fail', 'Email not registered');
    //     }
     }



    // Déconnecter l'utilisateur
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
