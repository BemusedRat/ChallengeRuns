<?php

    class SavedSplit extends DataObject {

        private static $db = array(
            'Title' => 'VarChar',
            'Hits' => 'VarChar',
            'PB' => 'VarChar',
            'Best' => 'VarChar',
            'Sort' => 'VarChar'
        );

        private static $has_one = array(
            'Parent' => 'ChallengeSplit'
        );

        private static $singular_name = 'Saved Split';
        private static $plural_name = 'Saved Splits';

        public function canView($member = null) {
           return true;
        }

        public function canEdit($member = null) {
           return true;
        }

        public function canDelete($member = null) {
           return true;
        }
        
        public function canCreate($member = null) {
           return true;
        }

    }