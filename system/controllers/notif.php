<?php

require_once 'system/auth.php';
require_once 'system/redirect.php';
require_once 'system/response.php';
require_once 'system/validation.php';
require_once 'system/tables/notif.php';

class NotifController
{
    public static function notify(array $data): void
    {
        $data = new Validation($data, true)
            ->add('id', ['required', 'integer'])
            ->add('text', ['required', 'max:500'], 'Text')
            ->finalize();

        $user = Auth::user();
        if (!($user && $user['admin'])) {
            JsonResponse::unauthorized();
        }

        NotifTable::insert([
            'heading' => 'Notifikasi dari admin',
            'text' => $data['text'],
            'recipient_id' => $data['id'],
        ], 'timestamp');
    }

    public static function notifData(array $data): void
    {
        $data = new Validation($data, true)->add('id', ['required', 'integer'])->finalize();
        $id = $data['id'];

        if (!UserTable::canEdit($id, Auth::user())) {
            Response::notFound();
        }

        JsonResponse::data([
            'count' => NotifTable::count($id),
        ]);
    }

    public static function clearNotifs(array $data): void
    {
        $data = new Validation($data, true)->add('id', ['required', 'integer'])->finalize();
        $id = $data['id'];

        if (!UserTable::canEdit($id, Auth::user())) {
            Response::notFound();
        }

        NotifTable::clearAll($id);
    }

    public static function deleteNotif(array $data): void
    {
        $data = new Validation($data, true)->add('id', ['required', 'integer'])->finalize();
        $id = $data['id'];

        if (!UserTable::canEdit($id, Auth::user())) {
            Response::notFound();
        }

        NotifTable::delete($id);
    }
}
