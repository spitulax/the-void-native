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
            ->add('heading', ['required', 'max:100'], 'Judul')
            ->add('text', ['max:500'], 'Teks')
            ->add('link_text', ['max:100'], 'Teks Link')
            ->add('link_address', ['max:100'], 'Alamat Link')
            ->finalize();

        $user = Auth::user();
        if (!($user && $user['admin'])) {
            JsonResponse::unauthorized();
        }

        $cols = [
            'heading' => $data['heading'],
            'text' => $data['text'] ?? '',
            'recipient_id' => $data['id'],
        ];

        if ($data['link_text'] && $data['link_address']) {
            $cols['link_text'] = $data['link_text'];
            $cols['link_address'] = $data['link_address'];
        }

        NotifTable::insert($cols, 'timestamp');
    }

    public static function notifData(array $data): void
    {
        $data = new Validation($data, true)->add('id', ['required', 'integer'])->finalize();
        $id = $data['id'];

        if (!UserTable::canEdit($id, Auth::user())) {
            JsonResponse::unauthorized();
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
            JsonResponse::unauthorized();
        }

        NotifTable::clearAll($id);
    }

    public static function deleteNotif(array $data): void
    {
        $data = new Validation($data, true)->add('id', ['required', 'integer'])->finalize();
        $id = $data['id'];

        $notif = NotifTable::fromId($id);

        if (!UserTable::canEdit($notif['recipient_id'], Auth::user())) {
            JsonResponse::unauthorized();
        }

        NotifTable::delete($id);
    }
}
