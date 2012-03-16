<?php
class TestEvent {
    function comment($event){
        echo get_class($event->sender);
    }
}