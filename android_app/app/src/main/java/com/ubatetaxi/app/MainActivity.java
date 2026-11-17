package com.ubatetaxi.app;

import android.Manifest;
import android.annotation.SuppressLint;
import android.app.AlertDialog;
import android.content.pm.PackageManager;
import android.os.Bundle;
import android.view.View;
import android.webkit.CookieManager;
import android.webkit.GeolocationPermissions;
import android.webkit.WebChromeClient;
import android.webkit.WebResourceError;
import android.webkit.WebResourceRequest;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ProgressBar;
import android.widget.TextView;
import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.app.ActivityCompat;
import androidx.core.content.ContextCompat;
import org.json.JSONObject;

public class MainActivity extends AppCompatActivity {

    private static final int LOCATION_PERMISSION_REQUEST = 1001;

    private WebView webView;
    private ProgressBar progressBar;
    private TextView tvApiStatus;
    private Button btnConfigIp;

    @SuppressLint("SetJavaScriptEnabled")
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        webView = findViewById(R.id.webView);
        progressBar = findViewById(R.id.progressBar);
        tvApiStatus = findViewById(R.id.tvApiStatus);
        btnConfigIp = findViewById(R.id.btnConfigIp);

        requestLocationPermissions();
        setupWebView();

        btnConfigIp.setOnClickListener(v -> showIpConfigDialog());

        loadTaxiApp();
    }

    @SuppressLint("SetJavaScriptEnabled")
    private void setupWebView() {
        WebSettings settings = webView.getSettings();
        settings.setJavaScriptEnabled(true);
        settings.setDomStorageEnabled(true);
        settings.setDatabaseEnabled(true);
        settings.setGeolocationEnabled(true);
        settings.setLoadWithOverviewMode(true);
        settings.setUseWideViewPort(true);
        settings.setMixedContentMode(WebSettings.MIXED_CONTENT_ALWAYS_ALLOW);

        // Identificador para que Laravel redirija directamente a la interfaz móvil (/movil) tras iniciar sesión
        settings.setUserAgentString(settings.getUserAgentString() + " UbateTaxiAndroid/2.4");

        CookieManager cookieManager = CookieManager.getInstance();
        cookieManager.setAcceptCookie(true);
        cookieManager.setAcceptThirdPartyCookies(webView, true);

        webView.setWebChromeClient(new WebChromeClient() {
            @Override
            public void onProgressChanged(WebView view, int newProgress) {
                if (newProgress < 100) {
                    progressBar.setVisibility(View.VISIBLE);
                    progressBar.setProgress(newProgress);
                } else {
                    progressBar.setVisibility(View.GONE);
                }
            }

            @Override
            public void onGeolocationPermissionsShowPrompt(String origin, GeolocationPermissions.Callback callback) {
                callback.invoke(origin, true, false);
            }
        });

        webView.setWebViewClient(new WebViewClient() {
            @Override
            public void onReceivedError(WebView view, WebResourceRequest request, WebResourceError error) {
                if (request.isForMainFrame()) {
                    showOfflineHelpPage(ApiConfig.getBaseUrl(MainActivity.this));
                }
            }
        });
    }

    private void loadTaxiApp() {
        final String baseUrl = ApiConfig.getBaseUrl(this);
        tvApiStatus.setText("● Conectando a " + baseUrl + "...");
        tvApiStatus.setTextColor(0xFFFBBF24);

        ApiService.checkServerStatus(baseUrl, new ApiService.ApiCallback() {
            @Override
            public void onSuccess(JSONObject response) {
                runOnUiThread(() -> {
                    int activeDrivers = response.optInt("active_drivers", 0);
                    int activeTrips = response.optInt("active_trips", 0);
                    tvApiStatus.setText("● API En Línea (" + activeDrivers + " taxis • " + activeTrips + " viajes)");
                    tvApiStatus.setTextColor(0xFF86EFAC);
                });
            }

            @Override
            public void onError(String errorMessage) {
                runOnUiThread(() -> {
                    tvApiStatus.setText("● Sin conexión a " + baseUrl);
                    tvApiStatus.setTextColor(0xFFF87171);
                });
            }
        });

        webView.loadUrl(baseUrl + "/movil");
    }

    private void showIpConfigDialog() {
        final EditText input = new EditText(this);
        input.setText(ApiConfig.getBaseUrl(this));
        input.setPadding(42, 32, 42, 32);

        new AlertDialog.Builder(this)
                .setTitle("Configurar URL del Servidor API")
                .setMessage("• Para Emulador Android Studio usa:\n  http://10.0.2.2:8000\n\n• Para Celular Físico por Wi-Fi usa:\n  http://192.168.1.38:8000")
                .setView(input)
                .setPositiveButton("Guardar y Conectar", (dialog, which) -> {
                    ApiConfig.setBaseUrl(MainActivity.this, input.getText().toString());
                    loadTaxiApp();
                })
                .setNeutralButton("Usar Emulador (10.0.2.2)", (dialog, which) -> {
                    ApiConfig.setBaseUrl(MainActivity.this, ApiConfig.EMULATOR_URL);
                    loadTaxiApp();
                })
                .setNegativeButton("Cancelar", null)
                .show();
    }

    private void showOfflineHelpPage(String attemptedUrl) {
        String html = "<html><body style='font-family:sans-serif;background:#0f172a;color:#fff;padding:28px;text-align:center;'>"
                + "<h2 style='color:#f59e0b;'>Ubaté Taxi — Servidor API no detectado</h2>"
                + "<p style='color:#94a3b8;font-size:14px;line-height:1.5;'>No se pudo conectar a:<br><b style='color:#fff;'>" + attemptedUrl + "</b></p>"
                + "<div style='background:#1e293b;padding:16px;border-radius:12px;text-align:left;font-size:13px;margin:20px 0;line-height:1.5;'>"
                + "<b>1. En tu PC</b>, asegúrate de iniciar el servidor ejecutando:<br>"
                + "<code style='color:#86efac;'>php artisan serve --host=0.0.0.0 --port=8000</code><br><br>"
                + "<b>2. Si estás en el Emulador de Android Studio:</b><br>"
                + "Toca el botón <b>Cambiar IP</b> arriba a la derecha y elige <code style='color:#fbbf24;'>http://10.0.2.2:8000</code>.<br><br>"
                + "<b>3. Si estás en un Celular Físico por Wi-Fi:</b><br>"
                + "Usa la IP Wi-Fi de tu PC: <code style='color:#fbbf24;'>http://192.168.1.38:8000</code>."
                + "</div>"
                + "</body></html>";
        webView.loadDataWithBaseURL(null, html, "text/html", "UTF-8", null);
    }

    private void requestLocationPermissions() {
        if (ContextCompat.checkSelfPermission(this, Manifest.permission.ACCESS_FINE_LOCATION)
                != PackageManager.PERMISSION_GRANTED) {
            ActivityCompat.requestPermissions(this,
                    new String[]{Manifest.permission.ACCESS_FINE_LOCATION, Manifest.permission.ACCESS_COARSE_LOCATION},
                    LOCATION_PERMISSION_REQUEST);
        }
    }

    @Override
    public void onBackPressed() {
        if (webView.canGoBack()) {
            webView.goBack();
        } else {
            super.onBackPressed();
        }
    }
}
