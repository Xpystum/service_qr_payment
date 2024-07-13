<?php
namespace App\Helpers\Values;

use Illuminate\Contracts\Database\Eloquent\Castable;
use InvalidArgumentException;
use JsonSerializable;

class AmountValue implements Castable, JsonSerializable
{
    private string $value; //123.45

    public function __construct(string $value)
    {

        if(!is_numeric($value)){
            throw new InvalidArgumentException(
                'Invalid amount value: ' . $value,
            );
        }

        $this->value = $value;
    }

    public function value(): string
    {
        //убрали (string)
        return $this->value;
    }

    //уможение
    public function mul(AmountValue $amount, ?int $scale = null): AmountValue
    {

        $result = bcmul($this->value(), $amount->value(), $scale);
        return new AmountValue($result);
    }

    //деление
    public function div(AmountValue $amount, ?int $scale = null): AmountValue
    {

        $result = bcdiv($this->value(), $amount->value(), $scale);

        return new AmountValue($result);
    }

    //сложение
    public function add(AmountValue $amount, ?int $scale = null): AmountValue
    {

        $result = bcadd($this->value(), $amount->value(), $scale);
        return new AmountValue($result);
    }

    //вычитание
    public function sub(AmountValue $amount, ?int $scale = null): AmountValue
    {

        $result = bcsub($this->value(), $amount->value(), $scale);
        return new AmountValue($result);
    }

    public static function castUsing(array $arguments)
    {
        return AmountCast::class;
    }

    public function __toString()
    {
        return (string) $this->value();
    }

    public function jsonSerialize()
    {
        return $this->value;
    }
}
