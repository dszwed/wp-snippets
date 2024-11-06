/**
 * Set header for Content-Security-Policy only for reporting
 * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/report-to
 * Send request is a POST
 */

header("Content-Security-Policy-Report-Only: default-src 'none'; report-uri https://example.com/csp-report");

