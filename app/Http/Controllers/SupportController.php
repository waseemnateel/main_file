<?php

namespace App\Http\Controllers;

use App\Models\Mail\TicketSend;
use App\Models\Employee;
use App\Models\Mail\UserCreate;
use App\Models\Support;
use App\Models\SupportReply;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SupportController extends Controller
{
    public function index()
    {
        if(\Auth::user()->type == 'company')
        {
            $supports = Support::where('created_by', \Auth::user()->creatorId())->get();
            $countTicket      = Support::where('created_by', '=', \Auth::user()->creatorId())->count();
            $countOpenTicket  = Support::where('status', '=', 'open')->where('created_by', '=', \Auth::user()->creatorId())->count();
            $countonholdTicket  = Support::where('status', '=', 'on hold')->where('created_by', '=', \Auth::user()->creatorId())->count();
            $countCloseTicket = Support::where('status', '=', 'close')->where('created_by', '=', \Auth::user()->creatorId())->count();
            return view('support.index', compact('supports','countTicket','countOpenTicket','countonholdTicket','countCloseTicket'));
        }
        elseif(\Auth::user()->type == 'client')
        {
            $supports = Support::where('user', \Auth::user()->id)->orWhere('ticket_created', \Auth::user()->id)->get();
            $countTicket      = Support::where('created_by', '=', \Auth::user()->creatorId())->count();
            $countOpenTicket  = Support::where('status', '=', 'open')->where('created_by', '=', \Auth::user()->creatorId())->count();
            $countonholdTicket  = Support::where('status', '=', 'on hold')->where('created_by', '=', \Auth::user()->creatorId())->count();
            $countCloseTicket = Support::where('status', '=', 'close')->where('created_by', '=', \Auth::user()->creatorId())->count();
            return view('support.index', compact('supports','countTicket','countOpenTicket','countonholdTicket','countCloseTicket'));
        }
        else
        {

            $supports = Support::where('user', \Auth::user()->id)->orWhere('ticket_created', \Auth::user()->id)->get();
            $countTicket      = Support::where('created_by', '=', \Auth::user()->creatorId())->count();
            $countOpenTicket  = Support::where('status', '=', 'open')->where('created_by', '=', \Auth::user()->creatorId())->count();
            $countonholdTicket  = Support::where('status', '=', 'on hold')->where('created_by', '=', \Auth::user()->creatorId())->count();
            $countCloseTicket = Support::where('status', '=', 'close')->where('created_by', '=', \Auth::user()->creatorId())->count();
            return view('support.index', compact('supports','countTicket','countOpenTicket','countonholdTicket','countCloseTicket'));
        }

    }


    public function create()
    {
        $priority = [
            __('Low'),
            __('Medium'),
            __('High'),
            __('Critical'),
        ];
        $status = Support::$status;
        $users = User::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
        return view('support.create', compact('priority', 'users','status'));
    }


    public function store(Request $request)
    {

        $validator = \Validator::make(
            $request->all(), [
                               'subject' => 'required',
                               'priority' => 'required',
                           ]
        );

        if($validator->fails())
        {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }

        $support              = new Support();
        $support->subject     = $request->subject;
        $support->priority    = $request->priority;
        $support->end_date    = $request->end_date;
        $support->ticket_code = date('hms');
        $support->status      = 'Open';

        if(!empty($request->attachment))
        {
            $fileName = time() . "_" . $request->attachment->getClientOriginalName();
            $request->attachment->storeAs('uploads/supports', $fileName);
            $support->attachment = $fileName;
        }
        $support->description    = $request->description;
        $support->created_by     = \Auth::user()->creatorId();
        $support->ticket_created = \Auth::user()->id;
        if(\Auth::user()->type == 'client')
        {
            $support->user = \Auth::user()->id;;
        }
        else
        {
            $request->user= $request->user;
        }

        $support->save();



        //Slack Notification
        $setting  = Utility::settings(\Auth::user()->creatorId());
        $support_priority = \App\Models\Support::$priority[$support->priority];
        $user = User::find($request->user);
        if(isset($setting['support_notification']) && $setting['support_notification'] ==1){
            $msg = __("New Support ticket created of").' ' .$support_priority .' '.__(" priority for").' ' . $user->name.'.';
            Utility::send_slack_msg($msg);
        }

        //Telegram Notification
        $setting  = Utility::settings(\Auth::user()->creatorId());
        $support_priority = \App\Models\Support::$priority[$support->priority];
        $user = User::find($request->user);
        if(isset($setting['telegram_support_notification']) && $setting['telegram_support_notification'] ==1){
            $msg = __("New Support ticket created of").' ' .$support_priority .' '.__(" priority for").' ' . $user->name.'.';
            Utility::send_telegram_msg($msg);
        }

        // send mail
        $id =!empty($request->user )? $request->user: \Auth::user()->id;
        $employee             = User::find($id);
        $support->name  = $employee->name;
        $support->email = $employee->email;

        try
        {
            Mail::to($support->email)->send(new TicketSend($support));
        }
        catch(\Exception $e)
        {
            $smtp_error = __('E-Mail has been not sent due to SMTP configuration');
        }
        return redirect()->route('support.index')->with('success', __('Support successfully added.'). (isset($smtp_error) ? $smtp_error : ''));



    }


    public function show(Support $support)
    {
        //
    }


    public function edit(Support $support)
    {
        $priority = [
            __('Low'),
            __('Medium'),
            __('High'),
            __('Critical'),
        ];
        $status = Support::$status;
        $users = User::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');

        return view('support.edit', compact('priority', 'users', 'support','status'));
    }


    public function update(Request $request, Support $support)
    {

        $validator = \Validator::make(
            $request->all(), [
                               'subject' => 'required',
                               'priority' => 'required',
                           ]
        );

        if($validator->fails())
        {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        $support->subject  = $request->subject;
        $support->user     = $request->user;
        $support->priority = $request->priority;
        $support->status  = $request->status;
        $support->end_date = $request->end_date;
        if(!empty($request->attachment))
        {
            $fileName = time() . "_" . $request->attachment->getClientOriginalName();
            $request->attachment->storeAs('uploads/supports', $fileName);
            $support->attachment = $fileName;
        }
        $support->description = $request->description;

        $support->save();

        return redirect()->route('support.index')->with('success', __('Support successfully created.'));

    }


    public function destroy(Support $support)
    {
        $support->delete();
        if($support->attachment)
        {
            \File::delete(storage_path('uploads/supports/' . $support->attachment));
        }

        return redirect()->route('support.index')->with('success', __('Support successfully deleted.'));

    }

    public function reply($ids)
    {
        $id      = \Crypt::decrypt($ids);
        $replyes = SupportReply::where('support_id', $id)->get();
        $support = Support::find($id);

        foreach($replyes as $reply)
        {
            $supportReply          = SupportReply::find($reply->id);
            $supportReply->is_read = 1;
            $supportReply->save();
        }

        return view('support.reply', compact('support', 'replyes'));
    }

    public function replyAnswer(Request $request, $id)
    {
        $supportReply              = new SupportReply();
        $supportReply->support_id  = $id;
        $supportReply->user        = \Auth::user()->id;
        $supportReply->description = $request->description;
        $supportReply->created_by  = \Auth::user()->creatorId();
        $supportReply->save();

        return redirect()->back()->with('success', __('Support reply successfully send.'));
    }

    public function grid()
    {

        if(\Auth::user()->type == 'company')
        {
            $supports = Support::where('created_by', \Auth::user()->creatorId())->get();

            return view('support.grid', compact('supports'));
        }
        elseif(\Auth::user()->type == 'client')
        {
            $supports = Support::where('user', \Auth::user()->id)->orWhere('ticket_created', \Auth::user()->id)->get();

            return view('support.grid', compact('supports'));
        }
        elseif(\Auth::user()->type == 'employee')
        {

            $supports = Support::where('user', \Auth::user()->id)->orWhere('ticket_created', \Auth::user()->id)->get();

            return view('support.grid', compact('supports'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
