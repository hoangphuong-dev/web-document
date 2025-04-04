<?php

namespace App\Policies;

use App\Enums\Document\DocumentStatus;
use App\Models\Document;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DocumentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function viewDetail(?User $user, Document $document): Response
    {
        //đăng nhập: admin => được luôn
        //đăng nhập: tác giả => không xem được khi đã xóa
        //không đăng nhập |đăng nhập: không phải tác giả => tài liệu được active

        if (!$user && $document->status->in([DocumentStatus::USER_DELETE, DocumentStatus::ADMIN_DELETE, DocumentStatus::NOT_APPROVED])) {
            return Response::denyWithStatus(410, 'Gone');
        }

        if ($user && ($user->isAdmin() || ($user->id === $document->owner_id && !$document->isDeleted()))) {
            $hasAccess = true;
        } else {
            $hasAccess = config('app.env') == 'production' ? $document->isPublic() : true;
        }

        return $hasAccess ? Response::allow() : Response::denyWithStatus(410, __('Tài liệu chưa public hoặc ko có trên hệ thống!'));
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Document $document): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Document $document): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Document $document): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Document $document): bool
    {
        return false;
    }
}
