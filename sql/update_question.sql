ALTER TABLE  `campaigns` ADD  `longdescription` LONGTEXT NOT NULL AFTER  `description`;
UPDATE `campaigns` SET
  `description`="Do you think the political parties should come under the RTI Act?<br />Do you oppose the RTI Amendment Bill? Tell your MP what you think.<br />Find your MP below. Make your voice count!",
  `longdescription` = "<p>The Right to Information (Amendment) Bill, 2013 seeks to amend the Right to Information Act 2005, removing political parties from the ambit of the definition of public authorities and hence from the purview of the RTI Act. If the amendment is passed by the parliament, citizens cannot access any information from political parties.</p>
  <p>The proposed amendment is against the basic foundations of a vibrant democracy, i.e., transparency and accountability.</p>
  <p>In Sep 2013, Citizens campaigned against the arbitrary move by the Government to pass the amendment. We called our MPs in a massive RTI Call-a-Thon campaign, urging and demanding them to stop this amendment. Several MPs heeded our call and opposed the amendments in the Parliament.</p>
  <p>This was the first of its kind in India.</p>
  <p>Our collective voice forced the Government to stop the amendment Bill and send it to the Parliamentary Standing committee.</p>
  <p>The threat is upon us again. The Bill will be brought again in the Winter Session of the Parliament, beginning on the 5th December.</p>
  <p>We have to make our voice heard again.</p>
  <p>Find your MP <a href='http://getrti.org/index.php/campaign/saverti'>here</a> and write to them opposing the RTI (Amendment) Bill. You can also find their contact numbers and call them.</p>
  <p>Act Now. Spread the Word. Join the SaveRTI Campaign.",
  `question`="Do you think the Parliament should pass the RTI Amendment Bill that keeps political parties out of the RTI Act?"
WHERE `campaigns`.`id`=1;