<?php

use App\Models\Money;

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

    $money2 = $money->add(new Money(2));
    expect($money2)->toBe($money);

    $money2 = $money->add(3.1);
    expect($money2)->toBe($money);

    $money2 = $money->add('5');
    expect($money2)->toBe($money);


    expect($money)->toEqual(new Money('12.53'));
});

test('subtract money', function () {
    $money = new Money('12.53');

    $money2 = $money->sub(new Money(2));
    expect($money2)->toBe($money);

    $money2 = $money->sub(3.1);
    expect($money2)->toBe($money);

    $money2 = $money->sub('5');
    expect($money2)->toBe($money);


    expect($money)->toEqual(new Money('2.43'));
});

test('multipy money', function () {
    $money = new Money('2.43');

    $money2 = $money->mul(new Money(2));
    expect($money2)->toBe($money);

    $money2 = $money->mul(3.1);
    expect($money2)->toBe($money);

    $money2 = $money->mul('5');
    expect($money2)->toBe($money);


    expect($money)->toEqual(new Money('75.33'));
});

test('divide money', function () {
    $money = new Money('75.33');

    $money2 = $money->div(new Money(2));
    expect($money2)->toBe($money);

    $money2 = $money->div(3.1);
    expect($money2)->toBe($money);

    $money2 = $money->div('5');
    expect($money2)->toBe($money);


    expect($money)->toEqual(new Money('2.43'));
});

test('render', function () {
    $money1 = new Money('2.4355651');

    expect($money1->render())->toEqual('2.44€');
});
