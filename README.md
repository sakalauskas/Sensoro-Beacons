# Sensoro Beacons & Eddystone EID
Some tips for developing with Sensoro Beacons for Eddystone EID beacons.

Since there are almost no information about this topic, I decided to publish ala short "blog post" how to resolve several issues with Eddystone EID beacons, where I spent numerous hours debugging.

# Problems

* First of all, Google Beacon API looks broken and does not really work, at least for me and I was not able to register and observe beacons successfully. Thus I would like to recommend develop your own Trusted resolver. Some sample code how to generate a identity key and know what EID will looks like some point in the future can be found in snippets directory. 
* Beacon counter has a integer overflow, every 255 seconds beacon delays for 1 second, thus leaving the beacon after several months unusable. Software workaround is implemented in BeaconTools.php class
* To connect and provision the beacon you will need a Beacon object. Details how to generate one can be found within BeaconFactory.java file
* Will post more solution to the problems as I will encounter them.

# Why buy Sensoro beacons? Not Estimote or other beacons?

I would have bought Estimote or kontakt.io, but their shipping and import taxes are too much and I only needed one for development and experimentation.

Sensoro, well, they have replacable batteries, are relatively cheap and have the support for Eddystone EID. This is why I sticked with them. Sadly they have a lot of problems, but at least I have found solutions for all of them at the time of writing. 

As well, I can configure the Eddystone EID rotation exponent to whatever I want (e.g. rotate ids every second) which is very convenient.


# Thanks?

Please Star this repository if you found it useful for your project or it helped resolve some issues you had.

If you have a beacon based project that you want to develop, you can as well contact me for work.
