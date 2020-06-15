<?php

class ajaxController extends ViewControl {
    
    public function delAlert() {
        unset($_SESSION['alert']);
    }

}
