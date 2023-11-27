<?php

namespace App\Http\Controllers;

use App\Events\SendMessage;
use App\Http\Resources\ConversationResource;
use App\Http\Resources\MessageResource;
use App\Http\Resources\UserResource;
use App\Models\InspectingInstitution;
use App\Models\InspectorUser;
use App\Models\InsuranceCompany;
use App\Models\InsuranceCompanyUser;
use App\Models\LogisticsCompany;
use App\Models\LogisticsCompanyUser;
use App\Models\Order;
use App\Models\OrderConversation;
use App\Models\User;
use App\Models\UserWarehouse;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Chat;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    public function index(User $user = null)
    {
        $conversation = null;
        $conversation_id = null;

        if ($user) {
            $conversation = Chat::conversations()->between(auth()->user(), $user);

            if (!$conversation) {
                $participants = [auth()->user(), $user];
                $conversation = Chat::createConversation($participants);
                $conversation->update([
                    'direct_message' => true,
                ]);
            }

            $conversation_id = $conversation->id;
            Chat::conversation($conversation)->setParticipant(auth()->user())->readAll();
            $conversation = Chat::conversation($conversation)->setParticipant(auth()->user())->limit(250000)->getMessages();

            $user->load('business');
        }

        $conversations = Chat::conversations()
                                ->setParticipant(auth()->user())
                                ->get();

        $conversations = Arr::pluck($conversations, 'conversation');

        $order_conversations = [];

        if (auth()->user()->hasRole('vendor')) {
            $order_conversations = auth()->user()->business->orders->pluck('id');

            $conversations = collect($conversations)->whereNotIn('id', $order_conversations);

            return view('business.chat.vue', [
                'conversations' => ConversationResource::collection($conversations),
                'conversation' => ['user' => $user, 'conversation_id' => $conversation ? $conversation_id : NULL, 'messages' => $conversation ? MessageResource::collection($conversation) : NULL],
                'user_id' => $user ? $user->id : NULL
            ]);
        }

        $order_conversations = auth()->user()->orders->pluck('id');

        $conversations = collect($conversations)->whereNotIn('id', $order_conversations);

        return view('chat.vue', [
            'conversations' => ConversationResource::collection($conversations),
            'conversation' => ['user' => $user, 'conversation_id' => $conversation ? $conversation_id : NULL, 'messages' => $conversation ? MessageResource::collection($conversation) : NULL],
            'user_id' => $user ? $user->id : NULL
        ]);
    }

    public function conversations(User $user = null)
    {
        $conversation = null;
        $conversation_id = null;

        if ($user) {
            $conversation = Chat::conversations()->between(auth()->user(), $user);

            if (!$conversation) {
                $participants = [auth()->user(), $user];
                $conversation = Chat::createConversation($participants);
                $conversation->update([
                    'direct_message' => true,
                ]);
            }

            $conversation_id = $conversation->id;
            Chat::conversation($conversation)->setParticipant(auth()->user())->readAll();
            $conversation = Chat::conversation($conversation)->setParticipant(auth()->user())->limit(250000)->getMessages();

            $user->load('business');
        }

        $conversations = Chat::conversations()
                                ->setParticipant(auth()->user())
                                ->get();

        $conversations = Arr::pluck($conversations, 'conversation');

        $order_conversations = [];

        if (auth()->user()->hasRole('vendor')) {
            $orders = auth()->user()->business->orders->pluck('id');
            $order_conversations = OrderConversation::whereIn('order_id', $orders)->get()->pluck('conversation_id');
        }

        if (auth()->user()->hasRole('buyer')) {
            $orders = auth()->user()->orders->pluck('id');
            $order_conversations = OrderConversation::whereIn('order_id', $orders)->get()->pluck('conversation_id');
        }

        $conversations = collect($conversations)->whereNotIn('id', $order_conversations);

        return response()->json([
            'conversations' => ConversationResource::collection($conversations),
            'conversation' => ['user' => $user, 'conversation_id' => $conversation ? $conversation_id : NULL, 'messages' => $conversation ? MessageResource::collection($conversation) : NULL],
            'auth_id' => auth()->id(),
        ], 200);
    }

    public function orderConversations(Order $order)
    {
        $conversations = Chat::conversations()
                                ->setParticipant(auth()->user())
                                ->get();

        $conversations = Arr::pluck($conversations, 'conversation');

        $order_conversations = [];

        $order_conversations = OrderConversation::where('order_id', $order->id)->get()->pluck('conversation_id');

        $conversations = collect($conversations)->whereIn('id', $order_conversations);

        return response()->json([
            'conversations' => ConversationResource::collection($conversations),
            'auth_id' => auth()->id(),
        ], 200);
    }

    public function view(Request $request, $id)
    {
        // Get one conversation
        $conversation = Chat::conversations()->getById($id);

        if (!$conversation) {
            toastr()->error('', 'Conversation not found');
        }

        $type = $request->query('type');
        $sender = $request->query('sender');

        $sender = $type::find($sender);

        Chat::conversation($conversation)->setParticipant($sender)->readAll();

        $messages = MessageResource::collection(Chat::conversation($conversation)->setParticipant($sender)->limit(250000)->getMessages());

        if(request()->wantsJson()) {
            return response()->json([
                'conversations' => ['messages' => $messages]
            ], 200);
        } else {
            return view('chat.index', [
                'conversations' => ['messages' => $messages]
            ]);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'conversation_id' => ['required'],
            'message' => ['required_without:files'],
            'files' => ['nullable', 'array'],
            'files.*' => ['max:10000']
        ]);

        if ($validator->fails()) {
            toastr()->error('', 'Invalid content. Files must be less than 10MiB');

            return response()->json($validator->messages(), 422);
        }

        $conversation = Chat::conversations()->getById($request->conversation_id);

        $type = $request->query('type');
        $sender = $request->query('sender');

        $sender = $type::find($sender);

        $files = [];
        if ($request->hasFile('files')) {
            foreach ($request->files as $file) {
                if (is_array($file)) {
                    foreach($file as $data) {
                        $size = filesize($data);
                        $originalFilename = pathinfo($data->getClientOriginalName(), PATHINFO_FILENAME);
                        // this is needed to safely include the file name as part of the URL
                        $newFilename = $originalFilename.'-'.uniqid().'.'.$data->guessExtension();
                        $data->move('storage/chat', $newFilename);
                        array_push($files, ['file_name' => $data->getClientOriginalName(), 'file_url' => config('app.url').'/storage/chat/'.$newFilename, 'file_size' => $size, 'file_type' => $data->getClientMimeType()]);
                    }
                }
            }
        }

        $message = Chat::message($request->message ? $request->message : 'files_only_message')->from($sender)->data($files)->to($conversation)->send();

        foreach ($conversation->getParticipants() as $participant) {
            if ($participant instanceof User) {
                if ($participant->id != $sender->id) {
                    $receiver = new UserResource($participant);
                    SendMessage::dispatch($receiver->email, $receiver, new MessageResource($message), new ConversationResource($conversation));
                    break;
                }
            }
            // elseif ($participant instanceof Warehouse) {
            //     $warehouses_manager_warehouses = UserWarehouse::where('user_id', $participant->id)->get()->pluck('warehouse_id');
            //     $warehouses = Warehouse::whereHas('users', function ($query) use ($warehouses_manager_warehouses) {
            //                                 $query->whereIn('id', $warehouses_manager_warehouses);
            //                             })
            //                             ->get()
            //                             ->pluck('id');
            //     if (!collect($warehouses)->contains($participant->id)) {
            //         $receiver = $participant;
            //         SendMessage::dispatch($receiver->email, $receiver, new MessageResource($message), new ConversationResource($conversation));
            //         break;
            //     }
            // } elseif ($participant instanceof InspectingInstitution) {
            //     $user_inspecting_institutions = InspectorUser::where('user_id', $participant->id)->get()->pluck('inspector_id');
            //     $inspectors = InspectingInstitution::whereHas('users', function ($query) use ($user_inspecting_institutions) {
            //                                 $query->whereIn('id', $user_inspecting_institutions);
            //                             })
            //                             ->get()
            //                             ->pluck('id');
            //     if (!collect($inspectors)->contains($participant->id)) {
            //         $receiver = $participant;
            //         SendMessage::dispatch($receiver->email, $receiver, new MessageResource($message), new ConversationResource($conversation));
            //         break;
            //     }
            // } elseif ($participant instanceof InsuranceCompany) {
            //     $user_insurance_companies = InsuranceCompanyUser::where('user_id', $participant->id)->get()->pluck('insurance_company_id');
            //     $insurers = InsuranceCompany::whereHas('users', function ($query) use ($user_insurance_companies) {
            //                                 $query->whereIn('id', $user_insurance_companies);
            //                             })
            //                             ->get()
            //                             ->pluck('id');
            //     if (!collect($insurers)->contains($participant->id)) {
            //         $receiver = $participant;
            //         SendMessage::dispatch($receiver->email, $receiver, new MessageResource($message), new ConversationResource($conversation));
            //         break;
            //     }
            // } elseif ($participant instanceof LogisticsCompany) {
            //     $user_logistics_company = LogisticsCompanyUser::where('user_id', $participant->id)->get()->pluck('logistics_company_id');
            //     $logistics_companies = LogisticsCompany::whereHas('users', function ($query) use ($user_logistics_company) {
            //                                 $query->whereIn('id', $user_logistics_company);
            //                             })
            //                             ->get()
            //                             ->pluck('id');
            //     if (!collect($logistics_companies)->contains($participant->id)) {
            //         $receiver = $participant;
            //         SendMessage::dispatch($receiver->email, $receiver, new MessageResource($message), new ConversationResource($conversation));
            //         break;
            //     }
            // }
        }

        if (request()->wantsJson()) {
            return response()->json(['message' => 'Message sent successfully', 'data' => new MessageResource($message)], 200);
        }

        return back();
    }
}
