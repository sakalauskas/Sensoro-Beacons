package uk.co.sakalauskas.your_app.util;

import android.os.Parcel;

import com.sensoro.beacon.kit.Beacon;

import java.lang.reflect.Field;

/**
 * To connect to a Sensoro Beacon we must have a com.sensoro.beacon.kit.Beacon object
 * However, I found some limitations (e.g. does not display the Eddystone EID values of beacon) 
 * while trying to discover the beacons, so I used 
 * altbeacon library to discover the beacons around. However, now I need to connect, but I do not have
 * a Beacon object. It is not possible to create or modify beacon object manually, since all fields are 
 * private amd there are no setter methods
 * 
 * We can use Java Reflections to modify the Beacon fields
 * 
 * @author Laurynas Sakalauskas - 2017-01-20
 *
 */

public class BeaconFactory {

    /**
     * Create a beacon using a reflection
     * since we do not have access to create
     * the beacon in any other way

     * @param macAddressToUse
     * @return
     */
    public static Beacon create(String macAddressToUse, String password) {

        // Just create a beacon from empty parcel.
        // Hopefully will not throw any exceptions
        Parcel out =  Parcel.obtain();
        final Beacon b = Beacon.CREATOR.createFromParcel(out);

        try {
            // Get fields
            Field macAddress = b.getClass().getDeclaredField("macAddress");
            Field version = b.getClass().getDeclaredField("firmwareVersion");
            Field passwordEnabled = b.getClass().getDeclaredField("isPasswordEnabled");

            // Set fields accessible
            macAddress.setAccessible(true);
            version.setAccessible(true);
            passwordEnabled.setAccessible(true);

            // set field attributes
            // we only need to set mac address, version number and whether we are
            // authenticating with password
            macAddress.set(b, macAddressToUse);
            version.set(b, "4.0");
            passwordEnabled.set(b, password.length() != 0);
        } catch (NoSuchFieldException | IllegalAccessException e) {
            e.printStackTrace();
        }
        return b;
    }
}
