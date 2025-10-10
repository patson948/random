# Social Authentication Setup Guide

This guide explains how to set up social authentication for the ShopHub application using Google, Facebook, and GitHub.

## Prerequisites

1. Laravel Socialite package is already installed
2. Database migration has been run to add social auth fields
3. Social authentication controller and routes are configured

## Environment Variables

Add the following environment variables to your `.env` file:

```env
# Google OAuth
GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback

# Facebook OAuth
FACEBOOK_CLIENT_ID=your_facebook_app_id
FACEBOOK_CLIENT_SECRET=your_facebook_app_secret
FACEBOOK_REDIRECT_URI=http://localhost:8000/auth/facebook/callback

# GitHub OAuth
GITHUB_CLIENT_ID=your_github_client_id
GITHUB_CLIENT_SECRET=your_github_client_secret
GITHUB_REDIRECT_URI=http://localhost:8000/auth/github/callback
```

## Setting Up OAuth Applications

### Google OAuth Setup

1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select an existing one
3. Enable the Google+ API
4. Go to "Credentials" → "Create Credentials" → "OAuth 2.0 Client IDs"
5. Set application type to "Web application"
6. Add authorized redirect URIs:
   - `http://localhost:8000/auth/google/callback` (for development)
   - `https://yourdomain.com/auth/google/callback` (for production)
7. Copy the Client ID and Client Secret to your `.env` file

### Facebook OAuth Setup

1. Go to [Facebook Developers](https://developers.facebook.com/)
2. Create a new app
3. Add Facebook Login product
4. Go to Facebook Login → Settings
5. Add valid OAuth redirect URIs:
   - `http://localhost:8000/auth/facebook/callback` (for development)
   - `https://yourdomain.com/auth/facebook/callback` (for production)
6. Copy the App ID and App Secret to your `.env` file

### GitHub OAuth Setup

1. Go to [GitHub Settings](https://github.com/settings/developers)
2. Click "New OAuth App"
3. Fill in the application details:
   - Application name: ShopHub
   - Homepage URL: `http://localhost:8000` (or your domain)
   - Authorization callback URL: `http://localhost:8000/auth/github/callback`
4. Copy the Client ID and Client Secret to your `.env` file

## Features

### Social Authentication Features

- **Google Login**: Users can sign in with their Google account
- **Facebook Login**: Users can sign in with their Facebook account
- **GitHub Login**: Users can sign in with their GitHub account
- **Account Linking**: Existing users can link their social accounts
- **Automatic Registration**: New users are automatically registered
- **Profile Sync**: User name and avatar are synced from social providers

### User Experience

- **Seamless Integration**: Social login buttons are integrated into login and register pages
- **Modern UI**: Beautiful social login buttons with proper branding
- **Error Handling**: Comprehensive error handling with user-friendly messages
- **Role Assignment**: New social users are assigned 'customer' role by default
- **Email Verification**: Social accounts are automatically email verified

### Security Features

- **Unique Constraints**: Social IDs are unique to prevent duplicate accounts
- **Secure Tokens**: Random passwords are generated for social accounts
- **Provider Tracking**: System tracks which provider was used for authentication
- **Account Linking**: Existing email accounts can be linked to social providers

## Database Schema

The following fields have been added to the `users` table:

```sql
google_id VARCHAR(255) NULL UNIQUE
facebook_id VARCHAR(255) NULL UNIQUE
github_id VARCHAR(255) NULL UNIQUE
avatar VARCHAR(255) NULL
provider VARCHAR(255) NULL
```

## Routes

The following routes have been added for social authentication:

```php
// Google OAuth
GET /auth/google
GET /auth/google/callback

// Facebook OAuth
GET /auth/facebook
GET /auth/facebook/callback

// GitHub OAuth
GET /auth/github
GET /auth/github/callback
```

## Controller Methods

The `SocialAuthController` includes the following methods:

- `redirectToGoogle()` - Redirects to Google OAuth
- `handleGoogleCallback()` - Handles Google OAuth callback
- `redirectToFacebook()` - Redirects to Facebook OAuth
- `handleFacebookCallback()` - Handles Facebook OAuth callback
- `redirectToGithub()` - Redirects to GitHub OAuth
- `handleGithubCallback()` - Handles GitHub OAuth callback
- `handleSocialCallback()` - Common logic for handling social callbacks
- `redirectAfterLogin()` - Redirects users based on their role

## Testing

To test social authentication:

1. Set up OAuth applications as described above
2. Add the environment variables to your `.env` file
3. Clear your application cache: `php artisan config:clear`
4. Visit the login page and click on social login buttons
5. Complete the OAuth flow with your social provider
6. Verify that you are logged in and redirected appropriately

## Troubleshooting

### Common Issues

1. **"Invalid redirect URI"**: Make sure the redirect URI in your OAuth app matches exactly
2. **"Client ID not found"**: Verify your environment variables are set correctly
3. **"Access denied"**: Check that your OAuth app is properly configured
4. **Database errors**: Ensure the migration has been run successfully

### Debug Mode

Enable debug mode in your `.env` file to see detailed error messages:

```env
APP_DEBUG=true
LOG_LEVEL=debug
```

## Production Deployment

For production deployment:

1. Update redirect URIs to use your production domain
2. Use HTTPS for all OAuth redirect URIs
3. Set secure environment variables
4. Test all social login flows thoroughly
5. Monitor logs for any authentication issues

## Security Considerations

- Always use HTTPS in production
- Keep OAuth client secrets secure
- Regularly rotate OAuth credentials
- Monitor for suspicious authentication attempts
- Implement rate limiting for authentication endpoints
