<h1><center>Routes in Calligraphic Job Board</center></h1>

The Job Board uses the new Joomla! routing system implemented in version 3.8.  The Job Board router provides `build()` and `parse()` proxy functions that call the new router system so that older SEF extensions still work.

**Defintion: segment**

Segments are each part of the URL between forward slashes, after the domain root, e.g.:

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; https://example.com/segment-1/segment-2

**Joomla! Home Page**

Joomla! uses the field `home` in `#__menu` to indicate which menu item should be shown when the URL is the domain root, e.g.:

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; https://example.com

Only one menu link can be set as the home page, and this is enforced in core Joomla! code via selecting the "home" button in the menu admin UI. The first segment (`segment-1` in the example above) must be an alias to a menu item. If you want content items to be accessible at the first segment, you must set them manually as menu items in the menu admin UI, e.g. as "menu type" being "Single Article":

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; https://example.com/my-article-1
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; https://example.com/my-article-2

There is a danger to this, as you may then have multiple routes to the same content item (the menu item link, and then a link to the content item through a category link which lists that content item and follows the "When viewing an article" pattern shown below). 

**Joomla! Default Content Routes**

When viewing the categories overview:

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; http://www.example.com/[menualias]

When viewing a category:

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; http://www.example.com/[menualias]/[category]

When viewing an article:

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; http://www.example.com/[menualias]/[category]/[article]

**Job Board Routes**

***View-based routes:***

These are fixed (and reserved keywords in the system), and checked for first before geographic job listings and company profiles. Current list at bottom.

***Regional job listings:***

need to override so can have a content landing page for city-state overriding the job board page

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; https://www.multifamilyinsiders.com/apartment-jobs/city-state  

  --or--
  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; https://www.multifamilyinsiders.com/apartment-jobs/north-dakota/grand-forks

***Individual Job Posting:***

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; https://www.multifamilyinsiders.com/apartment-jobs/city-state/job-title

  --or-- (using an employer-defined job number to distinguish between similar jobs)
  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; https://www.multifamilyinsiders.com/apartment-jobs/abc-property-management/myidnumber-leasing-consultant

***Company profiles:***

The company profile will also show all job postings that company has.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; https://www.multifamilyinsiders.com/apartment-jobs/company

***Reserved View Names:***

api
ats
application / applications
candidate / candidates
connector / connnectors
coupon / coupons
employer-panel
resume-alerts
review / reviews
help
job-seeker-panel
price-list
questionnaire / questionnaires
recommendation / recommendations
reference / references
resume / resumes
score-card / score-cards
subscription / subscriptions (should this be after an "employer" segment?)










