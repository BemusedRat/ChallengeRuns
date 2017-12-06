<?php

    class ChallengeAdmin extends ModelAdmin {

        private static $managed_models = array(
        	'ChallengeRoute',
        	'ChallengeGame'
        );
        private static $url_segment = 'challengerun';
        private static $menu_title = 'Challenge Runs';

    }