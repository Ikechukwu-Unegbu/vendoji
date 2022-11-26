<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\V1\extras\Contact;
use App\Models\V1\extras\Faq;
use App\Models\V1\extras\Faqcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ExtraController extends Controller
{
    public function contactus(){
        $contacts = Contact::orderBy('id', 'desc')->paginate(10);
        return view('admin.contacts.index')->with('contacts', $contacts);
    }

    public function faqdel($id){
        $faq = Faq::findOrFail($id);
        $faq->delete();
        Session::flash('success', "deleted");
        return redirect()->back();
    }

    public function contactResolve($id){
        $contacts = Contact::findOrFail($id);
        $contacts->solved= 1;
        $contacts->save();
        Session::flash('success', 'Successfully set to resolved.');
        return redirect()->back();
    }

    public function contactResolvePop($id){
        $contacts = Contact::findOrFail($id);
        $contacts->solved= 1;
        $contacts->delete();
        // $contacts->save();
        Session::flash('success', 'Successfully set to resolved and popped.');
        return redirect()->back();
    }

    public function faq(){
        $faq = Faq::orderBy('created_at', 'DESC')->get();
        $faqcategories = Faqcategory::get();
        return view('admin.faq.index', ['faqcategories' => $faqcategories])->with('faqs', $faq);
    }

    public function storeFaq(Request $request)
    {
        $request->validate([
            'question'  =>   'required|string|max:100',
            'category'  =>  'required',
            'answer'    =>  'required|string',
        ]);

        Faq::create([
            'question'  =>   $request->question,
            'category_id'  =>  $request->category,
            'answer'    =>  $request->answer,
        ]);

        Session::flash('success', 'FAQ Added Successfully');
        return redirect()->back();
    }

    public function faqcategory(){
        $faqCate = Faqcategory::all();
        return view('admin.faq.category')->with('cates', $faqCate);
    }

    public function newFaq(Request $request){
        $request->validate([
            'name'=>'required|string',
            'description'=>'required|string'
        ]);
        $faqCate = new Faqcategory();
        $faqCate->name = $request->name;
        $faqCate->description = $request->description;
        $faqCate->save();
        Session::flash('success', 'New FAQ category created');
        return redirect()->back();
    }

    public function editFaqCategory(Faqcategory $faqcategory, Request $request)
    {
        $request->validate([
            'name'=>'required|string',
            'description'=>'required|string'
        ]);

        $faqcategory->update([
            'name'  =>  $request->name,
            'description'   =>  $request->description
        ]);

        Session::flash('success', 'FAQ category updated Successfully');
        return redirect()->back();
    }

    public function destroyFaqCategory(Faqcategory $faqcategory)
    {
        $faqcategory->delete();
        Session::flash('success', 'FAQ category Deleted Successfully');
        return redirect()->back();
    }

    public function update(Request $request, $faqId){
        $request->validate([
            'question'=>'required|string',
            'answer'=>'required|string',
            'category'  =>  'required',
        ]);
        $faq = Faq::findOrFail($faqId);
        $faq->answer = $request->answer;
        $faq->question = $request->question;
        $faq->category_id = $request->category;
        $faq->save();

        Session::flash('success', 'FAQ successfully edited.');
        return redirect()->back();
    }
}
