<?php

namespace App\Http\Resources;

use App\Models\Business;
use App\Models\InspectingInstitution;
use App\Models\InsuranceCompany;
use App\Models\LogisticsCompany;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversationParticipantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $messageable = null;

        if ($this->messageable instanceof User) {
            $messageable = new UserResource($this->messageable);
        } elseif ($this->messageable instanceof Business) {
            $messageable = new VendorResource($this->messageable);
        } elseif ($this->messageable instanceof Warehouse) {
            $messageable = $this->messageable;
        } elseif ($this->messageable instanceof InspectingInstitution) {
            $messageable = $this->messageable;
        } elseif ($this->messageable instanceof InsuranceCompany) {
            $messageable = $this->messageable;
        } elseif ($this->messageable instanceof LogisticsCompany) {
            $messageable = $this->messageable;
        }

        return [
            'id' => $this->id,
            'conversation_id' => $this->conversation_id,
            'messageable_id' => $this->messageable_id,
            'messageable_type' => $this->messageable_type,
            'settings' => $this->settings,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'messageable' => $messageable,
        ];
    }
}
