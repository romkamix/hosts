<?php

namespace Romkamix\App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class HostCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($item) {
            $result = [
                'id' => $item->id,
                'name' => $item->name,
                'host' => $item->host,
                'port' => $item->port,
                'latency' => null,
                'checked_at' => null,
            ];

            $ping = $item->pings()
                ->orderBy('created_at', 'desc')
                ->first();

            if ($ping) {
                $result['latency'] = $ping->latency;
                $result['checked_at'] = $ping->created_at;
            }

            return $result;
        });
    }
}
