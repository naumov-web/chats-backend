<?php

namespace App\Enums;

/**
 * Class UseCaseSystemNamesEnum
 * @package App\Enums
 */
final class UseCaseSystemNamesEnum
{
    /**
     * Use case for registration of random user
     * @var string
     */
    public const REGISTER_RANDOM_USER = 'registerRandomUser';

    /**
     * Use case for registration of user with username and password
     * @var string
     */
    public const REGISTER_USER = 'registerUser';

    /**
     * Use case for login of user by username and password
     * @var string
     */
    public const LOGIN_USER = 'loginUser';

    /**
     * Use case for creation of new chat
     * @var string
     */
    public const CREATE_CHAT = 'createChat';

    /**
     * Use case for updating of specific chat
     * @var string
     */
    public const UPDATE_CHAT = 'updateChat';

    /**
     * Use case for deleting of specific chat
     * @var string
     */
    public const DELETE_CHAT = 'deleteChat';

    /**
     * Use case for getting of user's chats
     * @var string
     */
    public const GET_USER_CHATS = 'getUserChats';

    /**
     * Use case for creation of relation between chat and user
     * @var string
     */
    public const CREATE_CHAT_USER = 'createChatUser';

    /**
     * Use case for creation of chat message
     * @var string
     */
    public const CREATE_MESSAGE = 'createMessage';
}
