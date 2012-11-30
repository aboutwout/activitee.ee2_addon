## Activitee

Sort your entries by most recent activity (new entry, comments)

#### Tags
##### exp:activitee:entries
Works exactly like the {exp:channel:entries} tag.

      <ul>
      {exp:activitee:entries channel='blog'}
        <li>{title}</li>
      {/exp:activitee:entries}
      </ul>

There is a `{last_activity}` tag, but for the moment you can't use any date formatting on it just yet.


