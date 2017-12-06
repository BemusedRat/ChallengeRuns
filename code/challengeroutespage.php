<?php

    class RoutesPage extends Page {

        /*----------STATICS----------*/

        private static $db = array(
        );

        private static $has_one = array(
        );

        private static $has_many = array(

        );

        private static $defaults = array(
            
        );

        public static $many_many = array(

        );

        public static $summary_fields = array(
            
        );

        private static $singular_name = 'Routes Page';
        private static $plural_name = 'Routes Pages';

        /*--------END STATICS--------*/

        public function getCMSFields() {

            $fields = parent::getCMSFields();

            return $fields;
        }

        public function getChallengeRoutes() {
        	return ChallengeRoute::get();
        }

    }

    class RoutesPage_Controller extends Page_Controller {

        public function init() {
            parent::init();
            Requirements::javascript("framework/thirdparty/jquery/jquery.js");
            Requirements::javascript("challengeruns/js/challengejs.js");

        }

        private static $allowed_actions = array(
        	'routes',
        	'addHit',
        	'removeHit',
            'makeSplit',
        	'nextSplit',
        	'previousSplit',
        	'resetRun',
        	'saveSplits',
            'resetWholeRoute'
        );

        public function routes(SS_HTTPRequest $request) {
        	$Route = ChallengeRoute::get()->byID($request->param('ID'));

        	if(!$Route) {
        		return $this->httpError(404, "That run doesn't exist.");
        	}

        	// Set first Split to current if needed
        	$Splits = $Route->Splits();
        	if(!$Splits->filter(array('Curr'=>true))->First()) {
        		$this->setFirstSplitToCurrent($Splits);
        	}

        	return array(
        		'ChallengeRoute' => $Route,
        		'Title' => $Route->Title,
                'SumOfBest' => $Route->getSumOfBest()
        	);
        }

        //
        // Create and manage front-end run control
        //

        public function getCurrentRoute() {
        	$RouteID = $this->getRequest()->getVar('splitID');
        	$Route = ChallengeRoute::get()->byID($RouteID);
        	return $Route;
        }

        public function getSplits() {
        	$Route = $this->getCurrentRoute();
        	$Splits = $Route->Splits();
        	return $Splits;
        }

        public function getCurrentSplit() {
        	$CurrentRoute = $this->getCurrentRoute();
        	$CurrentSplit = $CurrentRoute->getCurrentSplit();
        	return $CurrentSplit;
        }

        public function getLastSplit() {
            $Splits = $this->getSplits();
            $LastSplit = $Splits->Last();
            return $LastSplit;
        }

        public function isLastSplit() {
            $LastSplit = $this->getLastSplit();
            $CurrentSplit = $this->getCurrentSplit();
            if($CurrentSplit->ID == $LastSplit->ID) {
                return true;
            } else {
                return false;
            }
        }

        public function setFirstSplitToCurrent($Splits) {
        	$FirstSplit = $Splits->First();
        	$FirstSplit->Curr = true;
        	$FirstSplit->write();
        	return null;
        }

        public function addHit() {
        	$CurrentSplit = $this->getCurrentSplit();
        	$CurrentHits = $CurrentSplit->Hits;
        	$CurrentSplit->Hits= ++$CurrentHits;
        	$CurrentSplit->write();
            if(Director::is_ajax()) {
                return false;
            }
        	return $this->redirectBack();

        }

        public function removeHit() {
        	$CurrentSplit = $this->getCurrentSplit();
        	$CurrentHits = $CurrentSplit->Hits;
        	if($CurrentHits > 0) {
        		$CurrentSplit->Hits= --$CurrentHits;
        	}
        	$CurrentSplit->write();
        	return $this->redirectBack();
        }

        // Decide whether to move to next split or complete run
        public function makeSplit() {
            if($this->isLastSplit()) {
                $Route = $this->getCurrentRoute();
                $Route->CompletedRuns += 1;
                $Route->IsComplete = true;
                $Route->write();
                return $this->redirectBack();
            } else {
                $this->nextSplit();
            }

        }

        public function nextSplit() {
        	$Splits = $this->getSplits();
        	$CurrentSplit = $this->getCurrentSplit();
        	$NextSort = $CurrentSplit->Sort + 1;
        	$NextSplit = $Splits->filter(array('Sort'=>$NextSort))->First();
        	$CurrentSplit->Curr = 0;
        	$NextSplit->Curr = 1;
        	$CurrentSplit->write();
        	$NextSplit->write();
        	return $this->redirectBack();
        }

        public function previousSplit() {
        	$Splits = $this->getSplits();
        	$CurrentSplit = $this->getCurrentSplit();
        	$PreviousSort = $CurrentSplit->Sort - 1;
        	$PreviousSplit = $Splits->filter(array('Sort'=>$PreviousSort))->First();
        	$CurrentSplit->Curr = 0;
        	$PreviousSplit->Curr = 1;
        	$CurrentSplit->write();
        	$PreviousSplit->write();
        	return $this->redirectBack();
        }

        public function resetRun() {
        	$Splits = $this->getSplits();
            $Route = $this->getCurrentRoute();
            $CurrentSplit = $this->getCurrentSplit();

            // Add a reset to the route if not complete
            if(!$Route->IsComplete) {

                $Route->Resets += 1;

                // Add a reset to the current split
                $CurrentSplit->RunKiller += 1;
                $CurrentSplit->write();
            }

        	// Reset all splits to zero hits and not current
        	foreach($Splits as $Split) {
        		$Split->Hits = 0;
        		$Split->Curr = 0;
        		$Split->write();
        	}

            // Return route to un-completed state, set new character and save
            $Route->IsComplete = 0;
            $Route->setNextCharacter();
            $Route->write();

        	// Reset first split as current
        	$this->setFirstSplitToCurrent($Splits);
        	return $this->redirectBack();
        }

        public function resetWholeRoute() {
            $Splits = $this->getSplits();
            $Route = $this->getCurrentRoute();

            // Reset all splits to zero hits and not current
            foreach($Splits as $Split) {
                $Split->Hits = 0;
                $Split->Curr = 0;
                $Split->PB = 0;
                $Split->Best = 0;
                $Split->write();
            }

            // Reset Route PB to 0
            $Route->PB = 0;
            $Route->write();

            // Reset first split as current
            $this->setFirstSplitToCurrent($Splits);
            return $this->redirectBack();
        }

        public function saveSplits() {
            $Splits = $this->getSplits();
            $Route = $this->getCurrentRoute();
            $RouteID = $Route->ID;
            $PB = $this->getPB();
            $TotalHits = 0;

            // Check and update PB and Best values
            foreach($Splits as $Split) {
                $Hits = $Split->Hits;
                $Best = $Split->Best;
                $TotalHits += $Hits;
                $isPB = $this->isPB();

                if($Hits < $Best || $PB == 0) {
                    $Split->Best = $Hits;
                }

                if($isPB || $PB == 0) {
                    $Split->PB = $Hits;
                }

                // Create and populate SavedSplit for this current split
                $SavedSplit = SavedSplit::create();
                $SavedSplit->ParentID = $Split->ID;
                $SavedSplit->Title = $Split->Title;
                $SavedSplit->Hits = $Split->Hits;
                $SavedSplit->PB = $Split->PB;
                $SavedSplit->Best = $Split->Best;
                $SavedSplit->Sort = $Split->Sort;
                $SavedSplit->write();

                $Split->write();

            }

            if($isPB || $PB == 0) {
                $Route->PB = $TotalHits;
                $Route->write();
            }

            $this->resetRun();

        	return $this->redirectBack();
        }

        public function getPB() {
            $Route = $this->getCurrentRoute();
            $PB = $Route->PB;
            return $PB;
        }

        public function isPB() {

            $Route = $this->getCurrentRoute();

            if(!$Route->IsComplete) {
                return false;
            }

            $PB = $this->getPB();

            $TotalHits = 0;
            $Splits = $this->getSplits();

            foreach($Splits as $Split) {
                $Hits = $Split->Hits;
                $TotalHits += $Hits;
            }

            if($TotalHits < $PB) {
                return true;
            }

            return false;
        }

    }