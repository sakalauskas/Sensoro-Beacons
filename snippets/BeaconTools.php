<?php namespace YourNamespace\Support;

use Symfony\Component\Process\Process;

/**
 * This class serves as a guide to implement your own 
 * Trusted resolver instead of using Google Proximity API, 
 * which seems broken and limited.
 * Note: requires Symfony\Process library to call the eidtools.py python script!
 * @author Laurynas Sakalauskas - 2017-01-05
 */
class BeaconTools {

    /**
     * Set the rotation exponent K: 2^K at which rate 
     * it should rotate the beacon
     * e.g. 2^6 = 64 seconds between the rotations
     * @return int
     */
    const ROTATION_EXPONENT = 6;
    
    /**
     * Generates a service key
     *
     * @return string
     */
    public static function newServiceKey() : string {
        return base64_encode(random_bytes(32));
    }

    /**
     * Creates a new identity key, base64 encoded
     *
     * @return string
     */
    public static function newIdentityKey() : string {
        $process = new Process('python eidtools.py registration '. escapeshellarg( 'b' . self::newServiceKey()) .' ' . self::ROTATION_EXPONENT);
        $process->setWorkingDirectory(base_path('python'));
        try {
            $process->mustRun();

            return trim($process->getOutput());

        } catch (ProcessFailedException $e) {
            echo "";
        }
    }

    /**
     * Generates a base64 encoded string of beacon id from base64 encoded identity key
     * and a beacon counter
     *
     * @param string $identityKey
     * @param int    $beaconTimeSeconds
     * @return string
     */
    public static function eid( string $identityKey, int $beaconTimeSeconds) : string {

        // Noticed that Sensoro SmartBeacon-4AA counter is a bit off.
        // Usually, beacon counter delays 1 second every 255 seconds.
        // This is a software workaround to fix the issue
        $offset = (int) ($beaconTimeSeconds / 255);

        if ($beaconTimeSeconds < 256)
            $offset -= 1;

        $beaconTimeSeconds = $beaconTimeSeconds  + $offset;

        $process = new Process('python eidtools.py eid '. escapeshellarg('b'.$identityKey) .' '. self::ROTATION_EXPONENT .' ' . escapeshellarg($beaconTimeSeconds));

        try {
            $process->mustRun();

            return trim($process->getOutput());

        } catch (ProcessFailedException $e) {
            echo "";
        }
    }
}
