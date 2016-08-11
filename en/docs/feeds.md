# Feeds

To create a ***Feed*** into a ***Board*** click the *Show* button into the desired Board.

Then click *Add Feed*.

Every Feed has a Name you can choose, and either an *API Key* or *Parameters* to configure.

> *Parameters* must be in valid JSON format. The structure is explained below.

### Whois Feed

To setup a *Whois* feed, use the following parameters structure:

Parameters:
```
{
    "domain": "condor.rocks"
}
```

### SSL Certificate Feed

To setup a *SSL Certificate* feed, use the following parameters structure:

Parameters:
```
{
    "url": "https://condor.rocks"
}
```

### Uptime Feed

Condor currently supports UptimeRobot as the uptime provider.

More providers will be added in the near future.

To setup an *Uptime* feed, just add your single-monitor ***UptimeRobot API Key***.
