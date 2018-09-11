### UKMrsvp_admin
Admin-grensesnitt for UKM hele året - UKMrsvp.


## Ting å sjekke dersom noe ikke funker

- Har serveren DNS til RSVP?
- Har du lagt til riktige tilganger i UKMid_admin?


## Påkrevde tilganger
UKMrsvp_admin må legges til i UKMid_admin, med API-nøkkel `ukmno_rsvp`, en gitt API-secret og følgende tillatelser for `system=rsvp`:
- readEvents
- createEvents.