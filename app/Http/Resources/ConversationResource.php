<?php

namespace App\Http\Resources;

use App\Models\InspectingInstitution;
use App\Models\InspectorUser;
use App\Models\InsuranceCompany;
use App\Models\InsuranceCompanyUser;
use App\Models\LogisticsCompany;
use App\Models\LogisticsCompanyUser;
use App\Models\User;
use App\Models\UserWarehouse;
use App\Models\Warehouse;
use Chat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $unread_count = 0;
        $receiver_unread_count = 0;
        if ($this->last_message) {
            $conversation = $conversation = Chat::conversations()->getById($this->id);
            foreach ($conversation->getParticipants() as $participant) {
                if ($participant instanceof User) {
                    if ($participant->id != auth()->id()) {
                        $receiver_unread_count = Chat::conversation($conversation)->setParticipant($participant)->unreadCount();
                    } else {
                        $unread_count = Chat::conversation($conversation)->setParticipant($participant)->unreadCount();
                    }
                } elseif ($participant instanceof Warehouse) {
                    $warehouses_manager_warehouses = UserWarehouse::where('user_id', $participant->id)->get()->pluck('warehouse_id');
                    $warehouses = Warehouse::whereHas('users', function ($query) use ($warehouses_manager_warehouses) {
                                                $query->whereIn('id', $warehouses_manager_warehouses);
                                            })
                                            ->get()
                                            ->pluck('id');
                    if (!collect($warehouses)->contains($participant->id)) {
                        $receiver_unread_count = Chat::conversation($conversation)->setParticipant($participant)->unreadCount();
                    } else {
                        $unread_count = Chat::conversation($conversation)->setParticipant($participant)->unreadCount();
                    }
                } elseif ($participant instanceof InspectingInstitution) {
                    $user_inspecting_institutions = InspectorUser::where('user_id', $participant->id)->get()->pluck('inspector_id');
                    $inspectors = InspectingInstitution::whereHas('users', function ($query) use ($user_inspecting_institutions) {
                                                $query->whereIn('id', $user_inspecting_institutions);
                                            })
                                            ->get()
                                            ->pluck('id');
                    if (!collect($inspectors)->contains($participant->id)) {
                        $receiver_unread_count = Chat::conversation($conversation)->setParticipant($participant)->unreadCount();
                    } else {
                        $unread_count = Chat::conversation($conversation)->setParticipant($participant)->unreadCount();
                    }
                } elseif ($participant instanceof InsuranceCompany) {
                    $user_insurance_companies = InsuranceCompanyUser::where('user_id', $participant->id)->get()->pluck('inspector_id');
                    $insurers = InsuranceCompany::whereHas('users', function ($query) use ($user_insurance_companies) {
                                                $query->whereIn('id', $user_insurance_companies);
                                            })
                                            ->get()
                                            ->pluck('id');
                    if (!collect($insurers)->contains($participant->id)) {
                        $receiver_unread_count = Chat::conversation($conversation)->setParticipant($participant)->unreadCount();
                    } else {
                        $unread_count = Chat::conversation($conversation)->setParticipant($participant)->unreadCount();
                    }
                } elseif ($participant instanceof LogisticsCompany) {
                    $user_logistics_company = LogisticsCompanyUser::where('user_id', $participant->id)->get()->pluck('inspector_id');
                    $logistics_companies = LogisticsCompany::whereHas('users', function ($query) use ($user_logistics_company) {
                                                $query->whereIn('id', $user_logistics_company);
                                            })
                                            ->get()
                                            ->pluck('id');
                    if (!collect($logistics_companies)->contains($participant->id)) {
                        $receiver_unread_count = Chat::conversation($conversation)->setParticipant($participant)->unreadCount();
                    } else {
                        $unread_count = Chat::conversation($conversation)->setParticipant($participant)->unreadCount();
                    }
                }
            }
        }
        return [
            'id' => $this->id,
            'private' => $this->private,
            'direct_message' => $this->direct_message,
            'data' => $this->data,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'unread_count' => $unread_count,
            'receiver_unread_count' => $receiver_unread_count,
            'last_message' => [
                'id' => $this->last_message ? $this->last_message->id : NULL,
                'message_id' => $this->last_message ? $this->last_message->message_id : NULL,
                'messageable_id' => $this->last_message ? $this->last_message->messageable_id  : NULL,
                'messageable_type' => $this->last_message ? $this->last_message->messageable_type : NULL,
                'conversation_id' => $this->last_message ? $this->last_message->conversation_id : NULL,
                'participation_id' => $this->last_message ? $this->last_message->participation_id : NULL,
                'is_seen' => $this->last_message ? $this->last_message->is_seen : NULL,
                'is_sender' => $this->last_message ? $this->last_message->is_sender : NULL,
                'flagged' => $this->last_message ? $this->last_message->flagged : NULL,
                'created_at' => $this->last_message ? $this->last_message->created_at : NULL,
                'updated_at' => $this->last_message ? $this->last_message->updated_at : NULL,
                'body' => $this->last_message ? $this->last_message->body : NULL,
                'type' => $this->last_message ? $this->last_message->type : NULL,
                'data' => $this->last_message ? $this->last_message->data : NULL,
                'sender' => $this->last_message ? new ConversationParticipantResource($this->last_message->sender) : NULL,
                'from_now' => $this->last_message ? Carbon::parse($this->last_message->created_at)->diffForHumans() : NULL,
            ],
            'participants' => ConversationParticipantResource::collection($this->participants),
        ];
    }
}
