<?php

    class ChallengeGame extends DataObject {

        private static $db = array(
            'Title' => 'VarChar'
        );

        private static $has_one = array(

        );

        private static $has_many = array(
            'Characters' => 'ChallengeCharacter',
            'ChallengeRoutes' => 'ChallengeRoute'
        );

        private static $many_many = array(

        );

        private static $belongs_many_many = array(

        );

        private static $defaults = array(

        );

        private static $default_sort = 'Title ASC';

        private static $summary_fields = array(

        );

        private static $searchable_fields = array(

        );

        private static $singular_name = 'Challenge Game';
        private static $plural_name = 'Challenge Games';

        public function getCMSFields() {
            $CharactersConfig = new GridFieldConfig_RecordEditor(20);
            $CharactersConfig->addComponent(new GridFieldEditableColumns());
            $CharactersConfig->addComponent(new GridFieldAddNewInlineButton());
            $CharactersConfig->addComponent(new GridFieldOrderableRows());
            $CharactersGrid = new GridField('Characters', 'Characters', $this->Characters(), $CharactersConfig);

            $fields = new FieldList(
                new TextField('Title'),
                $CharactersGrid
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