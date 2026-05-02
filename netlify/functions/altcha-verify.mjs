import { verifySolution } from 'altcha-lib/v1';

const HMAC_SECRET = process.env.ALTCHA_HMAC_SECRET || 'soil-on-site-altcha-local-secret';

const json = (statusCode, data) => ({
  statusCode,
  headers: {
    'Content-Type': 'application/json',
    'Cache-Control': 'no-store',
  },
  body: JSON.stringify(data),
});

export const handler = async event => {
  if (event.httpMethod !== 'POST') {
    return json(405, { error: 'Method not allowed' });
  }

  let body;
  try {
    body = JSON.parse(event.body || '{}');
  } catch (_) {
    return json(400, { error: 'Invalid JSON' });
  }

  if (typeof body.altcha !== 'string' || !body.altcha.trim()) {
    return json(400, { error: 'ALTCHA payload is missing or invalid' });
  }

  try {
    const verified = await verifySolution(body.altcha, HMAC_SECRET);

    return json(verified ? 200 : 403, {
      verified,
      error: verified ? null : 'ALTCHA verification failed',
    });
  } catch (_) {
    return json(500, { error: 'ALTCHA verification error' });
  }
};
