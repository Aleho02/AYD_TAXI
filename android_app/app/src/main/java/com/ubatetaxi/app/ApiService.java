package com.ubatetaxi.app;

import org.json.JSONObject;
import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.net.HttpURLConnection;
import java.net.URL;
import java.nio.charset.StandardCharsets;

/**
 * Cliente API Nativo para comunicarse con los endpoints JSON de Laravel (/api/*)
 */
public class ApiService {

    public interface ApiCallback {
        void onSuccess(JSONObject response);
        void onError(String errorMessage);
    }

    /**
     * Consultar el estado en vivo de la API: GET /api/status
     */
    public static void checkServerStatus(final String baseUrl, final ApiCallback callback) {
        new Thread(() -> {
            HttpURLConnection conn = null;
            try {
                URL url = new URL(baseUrl + "/api/status");
                conn = (HttpURLConnection) url.openConnection();
                conn.setRequestMethod("GET");
                conn.setRequestProperty("Accept", "application/json");
                conn.setConnectTimeout(4000);
                conn.setReadTimeout(4000);

                int code = conn.getResponseCode();
                BufferedReader reader = new BufferedReader(
                        new InputStreamReader(code >= 200 && code < 300 ? conn.getInputStream() : conn.getErrorStream(), StandardCharsets.UTF_8)
                );
                StringBuilder sb = new StringBuilder();
                String line;
                while ((line = reader.readLine()) != null) {
                    sb.append(line);
                }
                reader.close();

                if (code >= 200 && code < 300) {
                    callback.onSuccess(new JSONObject(sb.toString()));
                } else {
                    callback.onError("HTTP " + code);
                }
            } catch (Exception e) {
                callback.onError(e.getMessage());
            } finally {
                if (conn != null) conn.disconnect();
            }
        }).start();
    }

    /**
     * Enviar coordenadas GPS del conductor a POST /api/driver/location
     */
    public static void updateDriverLocation(final String baseUrl, final String bearerToken, final double lat, final double lng, final ApiCallback callback) {
        new Thread(() -> {
            HttpURLConnection conn = null;
            try {
                URL url = new URL(baseUrl + "/api/driver/location");
                conn = (HttpURLConnection) url.openConnection();
                conn.setRequestMethod("POST");
                conn.setRequestProperty("Content-Type", "application/json");
                conn.setRequestProperty("Accept", "application/json");
                conn.setRequestProperty("Authorization", "Bearer " + bearerToken);
                conn.setDoOutput(true);

                JSONObject payload = new JSONObject();
                payload.put("latitude", lat);
                payload.put("longitude", lng);
                payload.put("is_available", true);

                try (OutputStream os = conn.getOutputStream()) {
                    os.write(payload.toString().getBytes(StandardCharsets.UTF_8));
                }

                int code = conn.getResponseCode();
                BufferedReader reader = new BufferedReader(
                        new InputStreamReader(code >= 200 && code < 300 ? conn.getInputStream() : conn.getErrorStream(), StandardCharsets.UTF_8)
                );
                StringBuilder sb = new StringBuilder();
                String line;
                while ((line = reader.readLine()) != null) {
                    sb.append(line);
                }
                reader.close();

                if (code >= 200 && code < 300) {
                    callback.onSuccess(new JSONObject(sb.toString()));
                } else {
                    callback.onError("HTTP " + code);
                }
            } catch (Exception e) {
                callback.onError(e.getMessage());
            } finally {
                if (conn != null) conn.disconnect();
            }
        }).start();
    }
}
