<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\ApiInterface;
use App\Interfaces\UserInterface;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Exception;

class UserController extends Controller implements ApiInterface, UserInterface
{
    protected User $modelName;

    public function __construct()
    {
        $this->modelName = new User();
    }

    /**
     * Handle the index operation.
     *
     * @param Request $request
     * @return Response|ResponseFactory
     * @throws Exception
     */
    public function index(Request $request): Response|ResponseFactory
    {
        $allRecords = $this->modelName->fetchAllRecords($request->all());
        $data = [];

        if ($allRecords instanceof Collection || $allRecords instanceof LengthAwarePaginator) {
            $data['title'] = $allRecords->isNotEmpty()
                ? __('translations.success_title')
                : __('translations.not_found_title');
            $data['description'] = $allRecords->isNotEmpty()
                ? __('translations.success_message')
                : __('translations.not_found_message');
            $data['records'] = $allRecords;
            $statusCode = 200;
        } else {
            $data['title'] = __('translations.error_title');
            $data['description'] = __('translations.error_message');
            $data['results'] = [];
            $statusCode = 500;
        }

        return response($data, $statusCode);
    }

    /**
     * Handle the store operation.
     *
     * @param Request $request
     * @return Response|ResponseFactory
     * @throws Exception
     */
    public function store(Request $request): Response|ResponseFactory
    {
        $validatedRequest = $request->validate(UserRequest::rules());

        $insertRecord = [
            'full_name' => $this->getFullName($validatedRequest),
            'first_name' => $validatedRequest['first_name'],
            'last_name' => $validatedRequest['last_name'],
            'nickname' => null,
            'email' => $validatedRequest['email'],
            'phone' => null,
            'password' => $this->randomPasswordGenerator(),
            'profile_image' => $this->getProfileImageUrl($validatedRequest),
        ];

        $createdRecord = $this->modelName->createRecord($insertRecord);
        $data = [];

        if ($createdRecord instanceof User) {
            $data['title'] = __('translations.success_title');
            $data['description'] = __('translations.success_message');
            $data['results'] = $createdRecord;
            $statusCode = 201;
        } else {
            $data['title'] = __('translations.error_title');
            $data['description'] = __('translations.error_message');
            $data['results'] = [];
            $statusCode = 500;
        }

        return response($data, $statusCode);
    }

    /**
     * Handle the show operation.
     *
     * @param string $id
     * @param string|null $type
     * @return Response|ResponseFactory
     * @throws Exception
     */
    public function show(string $id, string|null $type = null): Response|ResponseFactory
    {
        $showRecord = $this->modelName->fetchSingleRecord($id);
        $data = [];

        if ($showRecord instanceof Collection) {
            $data['title'] = $showRecord->isNotEmpty()
                ? __('translations.success_title')
                : __('translations.not_found_title');
            $data['description'] = $showRecord->isNotEmpty()
                ? __('translations.success_message')
                : __('translations.not_found_message');
            $data['records'] = $showRecord;
            $statusCode = 200;
        } else {
            $data['title'] = __('translations.error_title');
            $data['description'] = __('translations.error_message');
            $data['results'] = [];
            $statusCode = 500;
        }

        return response($data, $statusCode);
    }

    /**
     * Handle the update operation.
     *
     * @param Request $request
     * @param string $id
     * @return Response|ResponseFactory
     * @throws Exception
     */
    public function update(Request $request, string $id): Response|ResponseFactory
    {
        $validatedRequest = $request->validate(UserRequest::rules());

        $showRecord = $this->modelName->fetchSingleRecord($id);
        $data = [];

        if ($showRecord instanceof Collection) {
            if ($showRecord->isNotEmpty()) {
                $updateRecord = [
                    'first_name' => array_key_exists('first_name', $request->all())
                        ? $validatedRequest['first_name']
                        : $showRecord->toArray()[0]['first_name'],
                    'last_name' => array_key_exists('last_name', $request->all())
                        ? $validatedRequest['last_name']
                        : $showRecord->toArray()[0]['last_name'],
                    'nickname' => array_key_exists('nickname', $request->all())
                        ? $validatedRequest['nickname']
                        : $showRecord->toArray()[0]['nickname'],
                    'email' => array_key_exists('email', $request->all())
                        ? $validatedRequest['email']
                        : $showRecord->toArray()[0]['email'],
                    'phone' => array_key_exists('phone', $request->all())
                        ? $validatedRequest['phone']
                        : $showRecord->toArray()[0]['phone'],
                    'password' => bcrypt($this->randomPasswordGenerator()),
                    'profile_image' => array_key_exists('profile_image', $request->all())
                        ? $validatedRequest['profile_image']
                        : $showRecord->toArray()[0]['profile_image'],
                ];

                $updateRecord['full_name'] = $this->getFullName($updateRecord);

                if (str_starts_with($showRecord->toArray()[0]['profile_image'], 'https://www.gravatar.com/avatar')) {
                    $updateRecord['profile_image'] = $this->getProfileImageUrl($validatedRequest);
                }

                $editedRecord = $this->modelName->updateRecord($updateRecord, $id);

                $data['title'] = __('translations.success_title');
                $data['description'] = __('translations.success_message');
                $data['results'] = $editedRecord;
                $statusCode = 200;
            } else {
                $data['title'] = __('translations.not_found_title');
                $data['description'] = __('translations.not_found_message');
                $data['results'] = [];
                $statusCode = 422;
            }
        } else {
            $data['title'] = __('translations.error_title');
            $data['description'] = __('translations.error_message');
            $data['results'] = [];
            $statusCode = 500;
        }

        return response($data, $statusCode);
    }

    /**
     * Handle the destroy operation.
     *
     * @param string $id
     * @return Response|ResponseFactory
     * @throws Exception
     */
    public function destroy(string $id): Response|ResponseFactory
    {
        $showRecord = $this->modelName->fetchSingleRecord($id);
        $data = [];

        if ($showRecord instanceof Collection) {
            if ($showRecord->isNotEmpty()) {
                $this->modelName->deleteRecord($id);
                $data['title'] = __('translations.success_title');
                $data['description'] = __('translations.success_message');
                $data['results'] = $showRecord;
                $statusCode = 200;
            } else {
                $data['title'] = __('translations.not_found_title');
                $data['description'] = __('translations.not_found_message');
                $data['results'] = [];
                $statusCode = 422;
            }
        } else {
            $data['title'] = __('translations.error_title');
            $data['description'] = __('translations.error_message');
            $data['results'] = [];
            $statusCode = 500;
        }

        return response($data, $statusCode);
    }

    /**
     * Handle the update user profile operation.
     *
     * @param Request $request
     * @param string $id
     * @return Response|ResponseFactory
     * @throws Exception
     */
    public function profile(Request $request, string $id): Response|ResponseFactory
    {
        $validatedRequest = $request->validate(UserRequest::rules());

        $showRecord = $this->modelName->fetchSingleRecord($id);

        if ($showRecord instanceof Collection) {
            if ($showRecord->isNotEmpty()) {
                $updateRecord = [
                    'first_name' => array_key_exists('first_name', $request->all())
                        ? $validatedRequest['first_name']
                        : $showRecord->toArray()[0]['first_name'],
                    'last_name' => array_key_exists('last_name', $request->all())
                        ? $validatedRequest['last_name']
                        : $showRecord->toArray()[0]['last_name'],
                    'nickname' => array_key_exists('nickname', $request->all())
                        ? $validatedRequest['nickname']
                        : $showRecord->toArray()[0]['nickname'],
                    'email' => array_key_exists('email', $request->all())
                        ? $validatedRequest['email']
                        : $showRecord->toArray()[0]['email'],
                    'phone' => array_key_exists('phone', $request->all())
                        ? $validatedRequest['phone']
                        : $showRecord->toArray()[0]['phone'],
                    'password' => bcrypt($this->randomPasswordGenerator()),
                    'profile_image' => array_key_exists('profile_image', $request->all())
                        ? $validatedRequest['profile_image']
                        : $showRecord->toArray()[0]['profile_image'],
                ];

                $updateRecord['full_name'] = $this->getFullName([
                    'first_name' => $updateRecord['first_name'],
                    'last_name' => $updateRecord['last_name'],
                ]);

                $editedRecord = $this->modelName->updateRecord($updateRecord, $id);

                $data['title'] = __('translations.success_title');
                $data['description'] = __('translations.success_message');
                $data['results'] = $editedRecord;
                $statusCode = 200;
            } else {
                $data['title'] = __('translations.not_found_title');
                $data['description'] = __('translations.not_found_message');
                $data['results'] = [];
                $statusCode = 422;
            }
        } else {
            $data['title'] = __('translations.error_title');
            $data['description'] = __('translations.error_message');
            $data['results'] = [];
            $statusCode = 500;
        }

        return response($data, $statusCode);
    }

    /**
     * Handle the full name based on request
     *
     * @param array $validatedRequest
     * @return string
     */
    private function getFullName(array $validatedRequest): string
    {
        return $validatedRequest['first_name'] . ' ' . $validatedRequest['last_name'];
    }

    /**
     * handle generate a random password.
     *
     * @return string The randomly generated password.
     */
    public function randomPasswordGenerator(): string
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%^&*()-_=+';
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        $length = 8;

        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }

        $currentRouteName = Route::current()->getName();

        if ($currentRouteName === 'register') {
            return bcrypt(implode($pass));
        }

        return implode($pass);
    }

    /**
     * Handle the gravatar profile image based on request
     *
     * @param array $validatedRequest
     * @return string
     */
    private function getProfileImageUrl(array $validatedRequest): string
    {
        $fullName = $validatedRequest['first_name'] . ' ' . $validatedRequest['last_name'];
        return vsprintf('https://www.gravatar.com/avatar/%s.jpg?s=200&d=%s', [
            md5(strtolower($validatedRequest['email'])),
            $fullName ? urlencode('https://ui-avatars.com/api/' . $fullName) : 'mp'
        ]);
    }
}
