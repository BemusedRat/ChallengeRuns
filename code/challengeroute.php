<?php

    class ChallengeRoute extends DataObject {

        private static $db = array(
            'Title' => 'VarChar',
            'PB' => 'Int',
            'Resets' => 'Int',
            'CompletedRuns' => 'Int',
            'IsComplete' => 'Boolean',
        );

        private static $has_one = array(
            'Game' => 'ChallengeGame',
            'Character' => 'ChallengeCharacter'
        );

        private static $has_many = array(
            'Splits' => 'ChallengeSplit',
        );

        private static $many_many = array(

        );

        private static $belongs_many_many = array(

        );

        private static $defaults = array(
            'Title' => 'Title',
            'PB' => 0,
            'Resets' => 0,
            'CompletedRuns' => 0,
            'IsComplete' => false
        );

        private static $summary_fields = array(
            'Title' => 'Route',
            'ChallengeGame' => 'Game',
            'PB' => 'PB',
            'Resets' => 'Resets',
            'CompletedRuns' => 'Completed Runs',
            'CurrentCharacter' => 'Current Character'
        );

        private static $searchable_fields = array(

        );

        private static $singular_name = 'Challenge Run';
        private static $plural_name = 'Challenge Runs';

        public function getCMSFields() {
            $SplitConfig = new GridFieldConfig_RecordEditor(20);
            $SplitConfig->addComponent(new GridFieldEditableColumns());
            $SplitConfig->addComponent(new GridFieldAddNewInlineButton());
            $SplitConfig->addComponent(new GridFieldOrderableRows());
            $SplitGrid = new GridField('Splits', 'Splits', $this->Splits(), $SplitConfig);

            $Games = ChallengeGame::get()->map('ID', 'Title')->toArray();
            $GameDropdown = new DropdownField(
                'GameID',
                'Game',
                $Games
            );

            $fields = new FieldList(
                new TextField('Title'),
                $GameDropdown,
                $SplitGrid
            );

            return $fields;
        }

        public function getChallengeGame() {
            if($this->GameID) {
                return $this->Game()->Title;
            } else {
                return "No game assigned";
            }
        }

        public function getCurrentCharacter() {
            if($this->CharacterID) {
                return $this->Character()->Name;
            } else {
                return "No character assigned";
            }
        }

        public function getCurrentSplit() {
            $CurrentSplit = $this->Splits()->filter(array(
                'Curr' => true
            ))->First();
            return $CurrentSplit;
        }

        public function getSumOfBest() {
            $Best = 0;
            $Splits = $this->Splits();

            foreach($Splits as $Split) {
                $Best += $Split->Best;
            }

            return $Best;
        }

        public function getCharacters() {
            $Game = $this->Game();
            $Characters = $Game->Characters();
            return $Characters;
        }

        public function getNextCharacter() {
            $Current = $this->Character()->Sort;
            $NextSort = $Current + 1;
            $Characters = $this->getCharacters();
            $Next = $Characters->filter(array('Sort' => $NextSort));
            if(!$Next->First()) {
                $Next = $Characters;
            }
            return $Next->First();
        }

        public function setNextCharacter() {
            $NextCharacter = $this->getNextCharacter();
            $this->CharacterID = $NextCharacter->ID;
            $this->write();
        }

        public function Link() {
            return $this->getRoutesPage()->Link('routes/' . $this->ID);
        }

        public function getRoutesPage() {
            $RoutesPages = RoutesPage::get();
            return $RoutesPages->First();
        }

        public function onBeforeWrite(){
            if($this->isChanged('GameID') || !$this->CharacterID) {
                $Game = $this->Game();
                $CharacterID = $Game->Characters()->First()->ID;
                $this->CharacterID = $CharacterID;
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