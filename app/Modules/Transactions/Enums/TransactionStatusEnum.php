<?php
namespace App\Modules\Transactions\Enums;
enum TransactionStatusEnum: string
{
    case pending = 'pending';

    case waiting_for_capture = 'waiting_for_capture';

    case completed = 'completed';

    case cancelled = 'cancelled';

    public function name(): string
    {
        return match($this){

            self::pending => 'Ожидает',

            self::waiting_for_capture => 'Ожидает Подтверждение',

            self::completed => 'Завершено',

            self::cancelled => 'Отмененa',

        };
    }

    private function is(TransactionStatusEnum $status): bool
    {
        return $this === $status;
    }

    public function isPending(): bool
    {

        return $this->is(TransactionStatusEnum::pending);
    }

    public function isWaiting(): bool
    {

        return $this->is(TransactionStatusEnum::waiting_for_capture);
    }

    public function isCompleted(): bool
    {

        return $this->is(TransactionStatusEnum::completed);
    }

    public function isCancelled(): bool
    {

        return $this->is(TransactionStatusEnum::cancelled);
    }

}
