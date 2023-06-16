<?php

namespace App\Http\Resources\Api;

use Illuminate\Support\Collection;

/**
 * Class ListResource
 * @package App\Http\Resources\Api
 */
final class ListResource extends BaseApiResource
{
    /**
     * Message value
     * @var string
     */
    private string $message;

    /**
     * Resource class name value
     * @var string
     */
    private string $resourceClassName;

    /**
     * Items collection
     * @var Collection
     */
    private Collection $items;

    /**
     * Total items count value
     * @var int
     */
    private int $count;

    /**
     * Convert object to array
     *
     * @param $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'success' => true,
            'message' => $this->message,
            'items' => $this->resourceClassName::collection($this->items),
            'count' => $this->count,
        ];
    }

    /**
     * Set message
     *
     * @param string $message
     * @return ListResource
     */
    public function setMessage(string $message): ListResource
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Set resource class name
     *
     * @param string $resourceClassName
     * @return ListResource
     */
    public function setResourceClassName(string $resourceClassName): ListResource
    {
        $this->resourceClassName = $resourceClassName;

        return $this;
    }

    /**
     * Set items collection
     *
     * @param Collection $items
     * @return $this
     */
    public function setItems(Collection $items): ListResource
    {
        $this->items = $items;

        return $this;
    }

    /**
     * Set total count value
     *
     * @param int $count
     * @return $this
     */
    public function setCount(int $count): ListResource
    {
        $this->count = $count;

        return $this;
    }
}
