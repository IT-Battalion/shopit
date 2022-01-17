<?php

use App\Types\Money;

test('create money', function () {
    $money1 = new Money('2.43');
    $money2 = new Money(2.43);
    $money3 = new Money($money2);

    expect($money1)->toEqual(new Money('2.43'));
    expect($money2)->toEqual(new Money('2.43'));
    expect($money3)->toEqual(new Money('2.43'));
});

test('add money', function () {
    $money = new Money('2.43');

    $money = $money->add(new Money(2));

    $money = $money->add(3.1);

    $money = $money->add('5');

    expect($money)->toEqual(new Money('12.53'));
});

test('subtract money', function () {
    $money = new Money('12.53');

    $money = $money->sub(new Money(2));

    $money = $money->sub(3.1);

    $money = $money->sub('5');

    expect($money)->toEqual(new Money('2.43'));
});

test('multipy money', function () {
    $money = new Money('2.43');

    $money = $money->mul(new Money(2));

    $money = $money->mul(3.1);

    $money = $money->mul('5');

    expect($money)->toEqual(new Money('75.33'));
});

test('divide money', function () {
    $money = new Money('75.33');

    $money = $money->div(new Money(2));

    $money = $money->div(3.1);

    $money = $money->div('5');

    expect($money)->toEqual(new Money('2.43'));
});

test('render', function () {
    $money1 = new Money('2.4355651');

    expect($money1->jsonSerialize())->toEqual('2,44€');
});
