emailHandling
=============
An example script which creates email templates and plugs in email receiver data.

```
This script should not be deployed on a public server. It is being used ****
as a learning process. Feedback on its efficacy are included with file  ****
descriptions.                                                           ****
```


The files below are used to create a record in the Template3 table.

templatetext.html
-----------------
A sample template containing the values Fname and Lname. Curly brackets outline
value. Pulled by SelectTable.php.

FormJQuery.html
---------------
Sample interface html page to access templates. Contains a listing of templates
(currently only one is active). Href of link is name of template form file
(RestForm.php used in example). Clicking on link calls AJAX GET to pull file
output into page.

RestForm1.php
-------------
Sample form using values required for email process.
This form POSTS to InsertTable.php


InsertTable.php
---------------
Example of email insertionInserts a row into "Template3" containing the values
POSTed from RestForm. In this sample, the ID, Keys, Values, and Body are set.

Note: Connection uses a set database, user name, and password. Consider define
file for values.

WARNING! - This is an insecure sample. The POST data is not getting verified prior
to execution. Recommend rewrite in PDO and variable scrubbing.

ID : The received ID is received directly from the RestForm text input. This
method invalidates the Primary Key index of the sample table. A sequence should
be applied instead.

Keys : the template plug in value names

Values : the values plugged in for this specific email

Body : the body of the email. Currently hard-coded to 'templatetext.html'.

Includes SelectTable.php at the end.


CreateTable.php
---------------
Creates two tables in Postgresql.

Template3 > ID (Primary key integer), Keys (text array), Values (text array),
            and Body (text).
sentmail3 > ID (Primary key integer), emailaddress (text)

These tables are created on file call (include or access).
There is not a function call nor checking for table existence. Connection
information is hard-coded.

Note: Using Postgresql's array column may be brought into question. It is not
supported in MySQL (which we won't hold against it because MySQL does many
things differently) but generally we use foreign keys with table joins to
work with array data.

------------------------------------------------------------------------------

The next set of files send emails based on form data.

SelectTable.php
---------------
Included by InsertTable.php

Pulls data from the template3 table.

Like other scripts, the database connection is hard-coded.

Gets contents of templatetext.html and performs string replace on double bracket
values. Results stored in a session named 'template'.  TemplatePreview.php is
then included and the database connection closed.


TemplatePreview.php
-------------------
A sample form to send an email.

Included at the end of the SelectTable.php script.

The form requests an id, a subject line, an receiver address list, and a body
containing the message.

Note: the body text area.

Session is started but not used in this file. Session started previously in
SelectTable.php.


InsertMessageTable.php
----------------------

TemplatePreview.php posts to this file. The POST array values are inserted into
two tables: sentemail3 and emailtemplatelog.

sentemail3 receives POST values named ID and tolist.

    ID : The received ID is received directly from the TemplatePreview text input.
    This method invalidates the Primary Key index of the sample table. A sequence
    should be implemented.

    tolist : a listing of email addresses saved to a text column.

emailtemplatelog receives POST values named ID, subject, and body.

    ID : Same value as referenced in sentemail3 above. Primary key irrelevant in
    this situation.

    subject: Subject of the email.

    body : Message body of email.

    status : not part of the POST process but saved as the hard-coded "sent".

All POST variables are copied into the SESSION with identical keys.

SedMessagefinal.php is included at the end of the script.

WARNING! - This is an insecure sample. The POST data is not getting verified prior
to execution. Recommend rewrite in PDO and variable scrubbing.

Notes:
The connection information is hard-coded.
Assuming the text is in either a newline or comma delineated format, the tolist
POST is not error checked.


SedMessagefinal.php
-------------------
Included at the end of InsertMessageTable.php.

Includes swift mailer library and then sends out emails. The user name and
password of the the SMTP transport connection service are hard-coded to use Gmail.

The message data is pulled from the session array created in InsertMessageTable.php
and piped into a Swift_Mailer object.

The From portion is hard-coded to use the connection Gmail account.

The To portion uses the content from the tolist session variable as the key to
an array. The value of the array is 'A name'. This example seems incomplete given
the reasons below.

The example given from Swift Mailer is as follows:

$mailer->setTo(array('receiver@domain.org', 'other@domain.org' => 'A name'));

In the example above demonstrates that setTo can receive a non-associative array
(e.g. [0 => 'foo@address.com', 1 => 'bar@address.com]);
an associative array
(e.g. ['foo@address.com' => 'Mr. Foo', 'bar@address.com' => 'Ms. Bar']);
or a combination of both (i.e. a numeric key is ignored in the mix).

The code in this file is as so:

$mailer->setTo(array($_SESSION['tolist'] => "A name"))

Recall the process of getting 'tolist'. This value is brought from the
InsertMessageTable.php file. It is a copy of the POST tolist value. Since that
value is a string, the setTo value would be in error.

For example, assuming:

$_SESSION['tolist'] = 'foo@address.com,bar@address.com';

Then the array would be keyed with the string as follows:

$mailer->setTo(array('foo@address.com,bar@address.com' => 'A name'));

The preferred format would be (unless Swift accepts the above, in which case this
advice can be ignored):

$mailer->setTo(array('foo@address.com'=>'A name', 'bar@address.com'=>'A name'));

The tolist value needs to be exploded and parsed on the comma/newline/semicolon
requested on the previous form.

If this file wants to include full names with their email addresses, a format
will need to be expressed in TemplatePreview. This could be via the standard
protocol (using a comma as the delineater):

Mr. Foo <foo@address.com>, Ms. Bar <bar@address.com>

or some by a multi-dimensional CSV format:

Mr. Foo:foo@address.com,Ms. Bar:bar@address.com

Whatever the case, string parsing is required to create the 'To' array required
for the setTo function.

Note: proper parsing is essential should the addressee's name contains an apostrophe.

This concludes notes about the setTo method call.

The setBody of the message object pulls the session variable 'body'.

Note that the message type (text/plain or text/html) is not set in this file. If
Swift Mailer defaults to html, no problem. A plain text format, in contrast,
could lead to an email filled with html tags. The script should allow either or
both.

The message is sent (thrice - two calls should be eliminated) and the number of
messages is displayed.
