function adlinkfly_get_url(url)
{
  var l = document.createElement('a');
  l.href = url;
  return l;
}

function adlinkfly_get_host_name(url)
{
  var domain;
  if (typeof url === 'undefined' || url === null || url === '' ||
      url.match(/^\#/)) {
    return '';
  }
  url = adlinkfly_get_url(url);
  if (url.href.search(/^http[s]?:\/\//) !== -1) {
    domain = url.href.split('/')[2];
  } else {
    return '';
  }
  domain = domain.split(':')[0];
  return domain.toLowerCase();
}

function adlinkfly_base64_encode(str)
{
  return btoa(encodeURIComponent(str).replace(
      /%([0-9A-F]{2})/g,
      function toSolidBytes(match, p1) {
        return String.fromCharCode('0x' + p1);
      }
  ));
}

function adlinkfly_get_wildcard_domains(domains)
{
  var wildcard_domains = [];

  for (i = 0; i < domains.length; i++) {
    if (domains[i].match(/^\*\./)) {
      wildcard_domains.push(domains[i].replace(/^\*\./, ''));
    }
  }

  return wildcard_domains;
}

function adlinkfly_match_wildcard_domain(domains, domain)
{
  var wildcard_domains = adlinkfly_get_wildcard_domains(domains);

  for (i = 0; i < wildcard_domains.length; i++) {
    if (domain.substr(wildcard_domains[i].length * -1) ===
        wildcard_domains[i]) {
      return true;
    }
  }

  return false;
}

function adlinkfly_domain_exist(domains, hostname)
{
  if (domains.indexOf(hostname) > -1) {
    return true;
  }

  return adlinkfly_match_wildcard_domain(domains, hostname);
}

document.addEventListener('DOMContentLoaded', function(event) {
  if (typeof adlinkfly_url === 'undefined') {
    return;
  }
  if (typeof adlinkfly_api_token === 'undefined') {
    return;
  }
  var advert_type = 1;
  if (typeof adlinkfly_advert !== 'undefined') {
    if (adlinkfly_advert == 2) {
      advert_type = 2;
    }
    if (adlinkfly_advert == 0) {
      advert_type = 0;
    }
  }
  var anchors = document.getElementsByTagName('a');
  if (typeof adlinkfly_domains !== 'undefined') {
    for (var i = 0; i < anchors.length; i++) {
      var hostname = adlinkfly_get_host_name(anchors[i].getAttribute('href'));
      if (hostname.length > 0 && adlinkfly_domain_exist(adlinkfly_domains, hostname)) {
        anchors[i].href = adlinkfly_url + 'full/?api=' + encodeURIComponent(
            adlinkfly_api_token
            ) + '&url=' + adlinkfly_base64_encode(anchors[i].href) + '&type=' +
            encodeURIComponent(advert_type);
      } else {
        if (anchors[i].protocol === 'magnet:') {
          anchors[i].href = adlinkfly_url + 'full/?api=' + encodeURIComponent(
              adlinkfly_api_token
              ) + '&url=' + adlinkfly_base64_encode(anchors[i].href) + '&type=' +
              encodeURIComponent(advert_type);
        }
      }
    }
    return;
  }
  if (typeof adlinkfly_exclude_domains !== 'undefined') {
    for (var i = 0; i < anchors.length; i++) {
      var hostname = adlinkfly_get_host_name(anchors[i].getAttribute('href'));
      if (hostname.length > 0 && adlinkfly_domain_exist(adlinkfly_exclude_domains, hostname) === false) {
        anchors[i].href = adlinkfly_url + 'full/?api=' + encodeURIComponent(
            adlinkfly_api_token
            ) + '&url=' + adlinkfly_base64_encode(anchors[i].href) + '&type=' +
            encodeURIComponent(advert_type);
      } else {
        if (anchors[i].protocol === 'magnet:') {
          anchors[i].href = adlinkfly_url + 'full/?api=' + encodeURIComponent(
              adlinkfly_api_token
              ) + '&url=' + adlinkfly_base64_encode(anchors[i].href) + '&type=' +
              encodeURIComponent(advert_type);
        }
      }
    }
    return;
  }
});
