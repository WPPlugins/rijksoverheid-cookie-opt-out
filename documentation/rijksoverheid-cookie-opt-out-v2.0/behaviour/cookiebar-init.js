/*
 * Rijksoverheid Cookie OPT-OUT v2.0
 * http://www.rijksoverheid.nl/cookies/
 * 
 * Copyright 2012 Rijksoverheid.nl, 
 * Public Information and Communication Office, 
 * Ministry of General Affairs
 * 
 * This script is distributed under the 
 * Creative Commons attribution-share alike license:
 * http://creativecommons.org/licenses/by-sa/3.0/
 * 
 * Changed compared to v1.1:
 * - no opt-in procedure
 * - just a message that cookies are being used
 * - assumes no third-party cookies are referenced
 */ 


/* Sample
 *
 */
  // First, set up cookies interface.
  RO.cookies.init();

  // Start cookiebar with a set of options.
  RO.cookiebar.init(
  {
	'NL-NL': {
		'text': 'Rijksoverheid.nl gebruikt cookies om het gebruik van de website te analyseren en het gebruiksgemak te verbeteren. Lees meer over ',
		'url': '/cookies/',
		'urltext': 'cookies'
    },

    'EN-GB':  // English version for xml:lang 'en-gb'
    {
		'text': 'Rijksoverheid.nl uses cookies to analyse the way our visitors use the site and to make it more user friendly. Learn more about ',
		'url': '/cookies/',
		'urltext': 'cookies'
    },

    cookiename: 'toestemmingvoorcookies',

    callback: function(result)
    {
      // If visitor agreed, we need to document this by setting a cookie and logging an URL with a unique code for legal reasons.
      // If the visitor disagreed, we just set a 'deny' cookie and request the image (cookieless!) without a unique code.
      var   agent = navigator.userAgent.hashCode(),
            now = new Date(),
            timestamp = Date.UTC(now.getFullYear(), now.getMonth(), now.getDate(), now.getHours(), now.getMinutes(), now.getSeconds(), now.getMilliseconds()),
            uniqueid = timestamp + agent.toString(),
            lifespan = RO.cookiebar.lifespan || 5*365,
            consent = RO.cookiebar.cookievalues[result],
            cookielog = new Image();

      if (result == "accept")
      {
        consent = consent + "." + uniqueid;
        
        // Add statistics code here, e.g. google analytics startup, comscore, or others.
        // This code is only triggered once, on the page where the visitor agrees to accept cookies.
      }

      // Remember choice in cookie.
      RO.cookies.create(RO.cookiebar.cookiename,consent,RO.cookiebar.lifespan);

      // Fetch an image to log visitor choice on server, with a unique code if visitor agreed.
      cookielog.src = "presentation/images/cookie.png?" + RO.cookiebar.cookiename + "=" + consent;
    }
  });
  
  
  // If a visitor returns after making a choice, you can test for the cookie as follows.
  var ck = RO.cookies[RO.cookiebar.cookiename] || '';
  if (ck.indexOf(RO.cookiebar.cookievalues['accept']) > -1)
  {
    // Put your cookie sensitive code, like statistics, here.
    alert("Bezoeker heeft cookies geaccepteerd. Yay!");
  }

