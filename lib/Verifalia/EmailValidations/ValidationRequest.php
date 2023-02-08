<?php

namespace Verifalia\EmailValidations {

	class ValidationRequest
	{
		public $entries = null;
		public $quality = null;
		public $deduplication = null;
		public $priority = null;
		public $retention = null;

		public function __construct($entries, $options = [])
		{
			$this->entries = array();

			if (is_array($entries)) {
				for ($x = 0; $x < count($entries); $x++) {
					$this->addEntry($entries[$x]);
				}
			} else {
				$this->addEntry($entries);
			}

            if (!empty($options))
                $this->setOptions($options);

		}

		private function addEntry($entry)
		{
			if (is_string($entry)) {
				array_push($this->entries, new ValidationRequestEntry($entry));
			} else if ($entry instanceof ValidationEntry) {
				array_push($this->entries, $entry);
			} else {
				throw new \InvalidArgumentException('Invalid input entries, please review the data you are about to submit to Verifalia.');
			}
		}

        private function setOptions(array $options) : void
        {
            if (isset($options['quality']))
                $this->setQuality($options['quality']);

            if (isset($options['deduplication']))
                $this->setDeduplication($options['deduplication']);

            if (isset($options['priority']))
                $this->setPriority($options['priority']);

            if (isset($options['retention']))
                $this->setRetention($options['retention']);
        }


        /**
         * @param 'Standard'|'High'|'Extreme' $quality
         */
        public function setQuality(string $quality) : void
        {
            if (!in_array($quality, ['Standard', 'High', 'Extreme']))
                return;
            $this->quality = $quality;
        }

        /**
         * @param 'Off'|'Safe'|'Relaxed' $dedupe
         */
        public function setDeduplication(string $dedupe) : void
        {
            if (!in_array($quality, ['Off', 'Safe', 'Relaxed']))
                return;
            $this->deduplication = $dedupe;
        }

        /**
         * @param $priority
         */
        public function setPriority(int $priority) : void
        {
            if ($priority < 0 || $priority > 255)
                return;
            $this->priority = $priority;
        }

        public function setRetention(string $retention) : void
        {
            if (empty($retention))
                return;

            $this->retention = $retention;

        }


    }
}

?>
