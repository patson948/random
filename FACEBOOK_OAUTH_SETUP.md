# Facebook OAuth Setup Guide

This guide provides detailed instructions for setting up Facebook OAuth authentication for ShopHub.

## Prerequisites

1. Facebook Developer Account
2. Laravel Socialite package installed
3. Environment variables configured

## Step-by-Step Facebook App Setup

### 1. Create Facebook App

1. Go to [Facebook Developers](https://developers.facebook.com/)
2. Click "My Apps" → "Create App"
3. Choose "Consumer" app type
4. Fill in app details:
   - **App Name**: ShopHub
   - **App Contact Email**: your-email@example.com
   - **App Purpose**: Select appropriate purpose

### 2. Add Facebook Login Product

1. In your app dashboard, click "Add Product"
2. Find "Facebook Login" and click "Set Up"
3. Choose "Web" platform
4. Enter your site URL: `http://localhost:8000` (for development)

### 3. Configure Facebook Login Settings

1. Go to Facebook Login → Settings
2. Add Valid OAuth Redirect URIs:
   - `http://localhost:8000/auth/facebook/callback` (development)
   - `https://yourdomain.com/auth/facebook/callback` (production)
3. Save changes

### 4. Configure App Settings

1. Go to Settings → Basic
2. Add App Domains:
   - `localhost` (for development)
   - `yourdomain.com` (for production)
3. Add Website URL: `http://localhost:8000`
4. Save changes

### 5. Set App Permissions

1. Go to Facebook Login → Settings
2. Ensure these permissions are available:
   - `email` (required)
   - `public_profile` (required)
3. Note: Some permissions may require app review for production

### 6. Get App Credentials

1. Go to Settings → Basic
2. Copy your **App ID** and **App Secret**
3. Add them to your `.env` file:

```env
FACEBOOK_CLIENT_ID=your_facebook_app_id
FACEBOOK_CLIENT_SECRET=your_facebook_app_secret
FACEBOOK_REDIRECT_URI=http://localhost:8000/auth/facebook/callback
```

## Common Facebook OAuth Issues

### Issue 1: "App Not Setup" Error

**Problem**: Facebook shows "App Not Setup" error
**Solution**: 
- Make sure your app is in "Live" mode
- Go to App Review → Permissions and Features
- Switch app to "Live" mode

### Issue 2: "Invalid Redirect URI" Error

**Problem**: Redirect URI mismatch error
**Solution**:
- Check that the redirect URI in Facebook app settings matches exactly
- Ensure no trailing slashes or extra characters
- Use the debug route `/facebook-debug` to verify configuration

### Issue 3: "Access Denied" Error

**Problem**: User denies permission or app doesn't have required permissions
**Solution**:
- Ensure your app requests `email` and `public_profile` permissions
- Check that permissions are approved (some require app review)

### Issue 4: "App Review Required" Error

**Problem**: Some permissions require Facebook app review
**Solution**:
- For development: Use test users or add yourself as a developer
- For production: Submit app for review with required permissions

### Issue 5: "Email Permission Denied" Error

**Problem**: App doesn't have email permission
**Solution**:
- Go to App Review → Permissions and Features
- Request `email` permission
- Submit for review if required

## Testing Facebook OAuth

### 1. Check Configuration

Visit `/facebook-debug` to verify your configuration:

```json
{
  "facebook_config": {
    "client_id": "Set",
    "client_secret": "Set",
    "redirect": "http://localhost:8000/auth/facebook/callback"
  },
  "app_url": "http://localhost:8000",
  "facebook_redirect_url": "http://localhost:8000/auth/facebook/callback"
}
```

### 2. Test OAuth Flow

1. Visit the login page
2. Click "Continue with Facebook"
3. Complete Facebook authorization
4. Check if you're redirected back and logged in

### 3. Check Logs

Monitor Laravel logs for Facebook OAuth activity:

```bash
tail -f storage/logs/laravel.log
```

Look for:
- `Facebook OAuth Success: user@example.com`
- `Social Auth Callback - Provider: facebook`
- Any error messages

## Production Deployment

### 1. Update Environment Variables

```env
FACEBOOK_CLIENT_ID=your_production_app_id
FACEBOOK_CLIENT_SECRET=your_production_app_secret
FACEBOOK_REDIRECT_URI=https://yourdomain.com/auth/facebook/callback
```

### 2. Update Facebook App Settings

1. Add production domain to App Domains
2. Add production redirect URI
3. Switch app to Live mode
4. Submit for app review if required

### 3. Remove Debug Routes

Remove these routes from production:
- `/facebook-debug`
- `/social-auth-test`

## Security Considerations

1. **Keep App Secret Secure**: Never expose your Facebook App Secret
2. **Use HTTPS**: Always use HTTPS in production
3. **Validate Redirect URIs**: Only allow trusted redirect URIs
4. **Monitor Usage**: Keep track of OAuth usage and errors
5. **Regular Updates**: Keep Facebook SDK and Laravel Socialite updated

## Troubleshooting Checklist

- [ ] Facebook app is created and configured
- [ ] Facebook Login product is added
- [ ] Valid OAuth redirect URIs are set
- [ ] App is in Live mode (for production)
- [ ] Required permissions are requested
- [ ] Environment variables are set correctly
- [ ] App domains are configured
- [ ] Website URL is set
- [ ] No trailing slashes in redirect URIs
- [ ] HTTPS is used in production
- [ ] Debug routes are removed in production

## Support

If you continue to have issues:

1. Check Facebook Developer Console for app status
2. Review Laravel logs for detailed error messages
3. Test with the debug route `/facebook-debug`
4. Verify all configuration steps are completed
5. Check Facebook's OAuth documentation for updates
