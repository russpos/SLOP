<?php

class ListingTest extends TPTest {

    public function beforeEach() {
        $this->list = new Listing('a', 'b', 'c', 123);
    }

    public function itShouldExist() {
        $this->expect($this->list)->toBeTruthy();
    }

    public function itShouldHaveArrayAccess() {
        $this->expect($this->list[0])->toEqual('a');
        $this->expect($this->list[1])->toEqual('b');
        $this->expect($this->list[2])->toEqual('c');
        $this->expect($this->list[3])->toEqual(123);
    }

    public function itShouldBeCountable() {
        $this->expect($this->list)->toHaveCount(4);
    }

    public function itShouldSetIntegerIndices() {
        $this->list[0] = 'foo';
        $this->expect($this->list[0])->toEqual('foo');
        $this->list[4] = 'bar';
        $this->expect($this->list[4])->toEqual('bar');
    }

    public function itShouldNotSetHighIntegerIndices() {
        try {
            $this->list[5] = 'bar';
        } catch (OutOfBoundsException $e) {
            $caught = true;
        }
        $this->expect($caught)->toBeTruthy();
    }

    public function itShouldNotSetNegativeIntegerIndices() {
        try {
            $this->list[-1] = 'bar';
        } catch (OutOfBoundsException $e) {
            $caught = true;
        }
        $this->expect($caught)->toBeTruthy();
    }

    public function itShouldNotSetNonIntegerIndices() {
        try {
            $this->list['cat'] = 'bar';
        } catch (OutOfRangeException $e) {
            $caught = true;
        }
        $this->expect($caught)->toBeTruthy();
    }

    public function itShouldBeLoopable() {
        $items = array();
        foreach ($this->list as $item) {
            $items[] = $item;
        }
        $this->expect($items)->toEqual(array('a', 'b', 'c', 123));
    }

    public function itCanBeCoercedToArray() {
        $items = $this->list->toArray();
        $this->expect($items)->toEqual(array('a', 'b', 'c', 123));
    }

    public function itCanPop() {
        $item = $this->list->pop();
        $this->expect($item)->toEqual('123');
        $this->expect($this->list->toArray())->toEqual(array('a', 'b', 'c'));
    }

    public function itCanPush() {
        $this->list->push('food');
        $items = $this->list->toArray();
        $this->expect($items)->toEqual(array('a', 'b', 'c', 123, 'food'));
    }

    public function itHasAppendAliasForPush() {
        $this->list->append('food');
        $items = $this->list->toArray();
        $this->expect($items)->toEqual(array('a', 'b', 'c', 123, 'food'));
    }

    public function itCanPushShorthanded() {
        $this->list[] = 'food';
        $this->expect($this->list->toArray())->toEqual(array('a', 'b', 'c', 123, 'food'));
    }

    public function itImplementsEveryArrayFunction() {
        $this->expect($this->list->keys()->toArray())->toEqual(array(0, 1, 2, 3));
    }

    public function itCanConcatenateArrays() {
        $this->list->concat(array('9', 'dog'));
        $this->expect($this->list->toArray())->toEqual(array('a', 'b', 'c', 123, '9', 'dog'));

        $this->list->concat(array('foo' => 'bar', 'baz' => 'barf'));
        $this->expect($this->list->toArray())->toEqual(array('a', 'b', 'c', 123, '9', 'dog', 'bar', 'barf'));

        $l = new Listing('sandwich', 'ham');
        $this->list->concat($l);
        $this->expect($this->list->toArray())->toEqual(array('a', 'b', 'c', 123, '9', 'dog', 'bar', 'barf', 'sandwich', 'ham'));

        try {
            $this->list->concat('catfish');
        } catch (InvalidArgumentException $e) {
            $caught = true;
        }
        $this->expect($caught)->toBeTruthy();
    }

    public function itShouldHaveExtendAliasForConcat() {
        $this->list->extend(array('9', 'dog'));
        $this->expect($this->list->toArray())->toEqual(array('a', 'b', 'c', 123, '9', 'dog'));
    }

    public function itShouldSlice() {
        $slice = $this->list->slice(1, 2);
        $this->expect($slice->toArray())->toEqual(array('b', 'c'));
    }

    public function itShouldContain() {
        $this->expect($this->list->contains('b'))->toBeTruthy();
        $this->expect($this->list->contains('x'))->toBeFalsy();
    }

    public function itShouldDelete() {
        unset($this->list[2]);
        $this->expect($this->list->toArray())->toEqual(array('a', 'b', 123));
    }

}
