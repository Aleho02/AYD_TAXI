package com.ubatetaxi.app;

import android.content.Context;
import android.content.SharedPreferences;
import android.os.Build;

public class ApiConfig {
    private static final String PREFS_NAME = "UbateTaxiPrefs";
    private static final String KEY_BASE_URL = "base_url";

    // IP especial de Android Studio para conectarse al localhost (127.0.0.1) del PC desde el Emulador
    public static final String EMULATOR_URL = "http://10.0.2.2:8000";

    // IP de la red Wi-Fi local de tu PC para celulares físicos conectados al mismo Wi-Fi
    public static final String WIFI_DEVICE_URL = "http://192.168.1.38:8000";

    public static boolean isEmulator() {
        return (Build.BRAND.startsWith("generic") && Build.DEVICE.startsWith("generic"))
                || Build.FINGERPRINT.startsWith("generic")
                || Build.FINGERPRINT.startsWith("unknown")
                || Build.HARDWARE.contains("goldfish")
                || Build.HARDWARE.contains("ranchu")
                || Build.MODEL.contains("google_sdk")
                || Build.MODEL.contains("Emulator")
                || Build.MODEL.contains("Android SDK built for x86")
                || Build.MANUFACTURER.contains("Genymotion")
                || Build.PRODUCT.contains("sdk_gphone")
                || Build.PRODUCT.contains("vbox86p")
                || Build.PRODUCT.contains("emulator");
    }

    public static String getBaseUrl(Context context) {
        SharedPreferences prefs = context.getSharedPreferences(PREFS_NAME, Context.MODE_PRIVATE);
        String defaultUrl = isEmulator() ? EMULATOR_URL : WIFI_DEVICE_URL;
        return prefs.getString(KEY_BASE_URL, defaultUrl);
    }

    public static void setBaseUrl(Context context, String url) {
        String cleanUrl = url.trim();
        if (cleanUrl.endsWith("/")) {
            cleanUrl = cleanUrl.substring(0, cleanUrl.length() - 1);
        }
        SharedPreferences prefs = context.getSharedPreferences(PREFS_NAME, Context.MODE_PRIVATE);
        prefs.edit().putString(KEY_BASE_URL, cleanUrl).apply();
    }
}
