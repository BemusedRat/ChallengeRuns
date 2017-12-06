<?php

    class ChallengeCharacter extends DataObject {

        private static $db = array(
            'Name' => 'VarChar',
            'Sort' => 'Int'
        );

        private static $has_one = array(
        	'Game' => 'ChallengeGame'
        );

        private static $has_many = array(

        );

        private static $many_many = array(

        );

        private static $belongs_many_many = array(

        );

        private static $defaults = array(

        );

        private static $default_sort = 'Name ASC';

        private static $summary_fields = array(

        );

        private static $searchable_fields = array(

        );

        private static $singular_name = 'Character';
        private static $plural_name = 'Characters';

        public function getCMSFields() {

            $fields = new FieldList(
                new TextField('Name')
            );

            return $fields;
        }

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