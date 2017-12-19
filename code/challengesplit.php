<?php

    class ChallengeSplit extends DataObject {

        private static $db = array(
            'Title' => 'VarChar',
            'Hits' => 'Int',
            'PB' => 'Int',
            'Best' => 'Int',
            'Sort' => 'Int',
            'Curr' => 'Boolean',
            'RunKiller' => 'Int',
            'Completed' => 'Boolean',
            'Dexterity' => 'Int'
        );

        private static $has_one = array(
            'Route' => 'ChallengeRoute'
        );

        private static $has_many = array(
            'SavedSplits' => 'SavedSplit'
        );

        private static $many_many = array(

        );

        private static $belongs_many_many = array(

        );

        private static $defaults = array(
            'Title' => 'Title',
            'Hits' => 0,
            'RunKiller' => 0,
            'Completed' => false,
            'Dexterity' => 0
        );

        private static $default_sort = array(
            'Sort'
        );

        private static $summary_fields = array(
            'Title',
            'PB',
            'Best'
        );

        private static $searchable_fields = array(

        );

        private static $singular_name = 'Challenge Split';
        private static $plural_name = 'Challenge Splits';

        public function getCMSFields() {

            $fields = new FieldList(
                new TextField('Title'),
                new NumericField('Dexterity')
            );

            return $fields;
        }

        protected function onBeforeWrite() {
            if (!$this->Sort) {
                $this->Sort = ChallengeSplit::get()->max('Sort') + 1;
            }
            
            parent::onBeforeWrite();
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