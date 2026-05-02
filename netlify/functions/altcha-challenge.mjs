import { createChallenge } from 'altcha-lib/v1';

const HMAC_SECRET = process.env.ALTCHA_HMAC_SECRET || 'soil-on-site-altcha-local-secret';

const json = (statusCode, data) => ({
  statusCode,
  headers: {
    'Content-Type': 'application/json',
    'Cache-Control': 'no-store',
  },
  body: JSON.stringify(data),
});

export const handler = async () => {
  const challenge = await createChallenge({
    algorithm: 'SHA-256',
    hmacKey: HMAC_SECRET,
    maxnumber: 30000,
    number: Math.floor(Math.random() * 24000) + 3000,
    expires: new Date(Date.now() + 10 * 60 * 1000),
  });

  return json(200, challenge);
};
