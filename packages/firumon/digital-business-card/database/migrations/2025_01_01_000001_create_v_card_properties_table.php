<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('v_card_properties', function (Blueprint $table) {
            $table->id();
            $table->string('property')->index();
            $table->string('category')->nullable();
            $table->text('parameters')->nullable();
            $table->string('value_type')->nullable();
            $table->text('example')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
        $Data = [["property","category","value_type","description","example","parameters"],["BEGIN","Core","text","Beginning marker for vCard","BEGIN:VCARD",""],["END","Core","text","Ending marker for vCard","END:VCARD",""],["VERSION","Core","text","vCard format version","VERSION:4.0",""],["FN","Core","text","Formatted name (display name)","FN:John Doe","LANGUAGE, ALTID, PID, PREF, TYPE"],["N","Identification","structured text","Name components (Family;Given;Additional;Prefix;Suffix)","N:Doe;John;Quinlan;Dr.;Jr.","LANGUAGE, SORT-AS, ALTID"],["NICKNAME","Identification","text list","Nickname or familiar name","NICKNAME:Johnny,JQ","TYPE, LANGUAGE, ALTID, PID, PREF"],["PHOTO","Identification","URI","Photo or image of the person","PHOTO:https://example.com/photo.jpg","ALTID, TYPE, MEDIATYPE, PREF, PID"],["BDAY","Identification","date/time","Birthday","BDAY:19850315","VALUE, ALTID, CALSCALE"],["ANNIVERSARY","Identification","date/time","Anniversary date","ANNIVERSARY:20100612","VALUE, ALTID, CALSCALE"],["GENDER","Identification","structured text","Gender identity","GENDER:M;Male",""],["ADR","Addressing","structured text","Address (PO Box;Extended;Street;City;State;Postal;Country)","ADR;TYPE=work:;;123 Main St;New York;NY;10001;USA","TYPE, PREF, ALTID, PID, LABEL, GEO, TZ, LANGUAGE"],["LABEL","Addressing","text","Delivery address label","LABEL;TYPE=work:123 Main St\nNew York, NY 10001","TYPE, PREF, ALTID, PID, LANGUAGE"],["TEL","Communication","URI/text","Telephone number","TEL;TYPE=work:+1-555-123-4567","TYPE, PREF, ALTID, PID, VALUE"],["EMAIL","Communication","text","Email address","EMAIL;TYPE=work:john@example.com","TYPE, PREF, ALTID, PID"],["IMPP","Communication","URI","Instant messaging and presence protocol","IMPP;SERVICE-TYPE=Skype:skype:john.doe","TYPE, PREF, ALTID, PID, SERVICE-TYPE, USERNAME"],["LANG","Communication","language-tag","Language preference","LANG:en-US","TYPE, PREF, ALTID, PID"],["TZ","Geographical","URI/utc-offset/text","Time zone","TZ:-05:00","TYPE, PREF, ALTID, PID, VALUE"],["GEO","Geographical","URI","Geographic coordinates","GEO:geo:40.7128,-74.0060","TYPE, PREF, ALTID, PID"],["TITLE","Organizational","text","Job title or position","TITLE:Software Engineer","TYPE, LANGUAGE, PREF, ALTID, PID"],["ROLE","Organizational","text","Role or function","ROLE:Developer","TYPE, LANGUAGE, PREF, ALTID, PID"],["LOGO","Organizational","URI","Organization logo","LOGO:https://company.com/logo.png","TYPE, PREF, ALTID, PID, MEDIATYPE"],["ORG","Organizational","structured text","Organization name and units","ORG:ACME Inc.;Development;Web Team","TYPE, LANGUAGE, PREF, ALTID, PID, SORT-AS"],["MEMBER","Organizational","URI","Group membership","MEMBER:mailto:member@group.com","TYPE, PREF, ALTID, PID, MEDIATYPE"],["CATEGORIES","Explanatory","text list","Application categories or tags","CATEGORIES:WORK,DEVELOPER","TYPE, PREF, ALTID, PID"],["NOTE","Explanatory","text","Supplemental information","NOTE:Software developer with 10 years experience","TYPE, LANGUAGE, PREF, ALTID, PID"],["PRODID","Explanatory","text","Product identifier","PRODID:-//Company//App 1.0//EN",""],["REV","Explanatory","timestamp","Revision timestamp","REV:20250831T131000Z",""],["SOUND","Explanatory","URI","Sound or pronunciation guide","SOUND:https://example.com/name.wav","TYPE, PREF, ALTID, PID, MEDIATYPE, LANGUAGE"],["UID","Explanatory","URI","Unique identifier","UID:urn:uuid:4fbe8971-0bc3-424c",""],["KEY","Security","URI/text","Security key or certificate","KEY:https://example.com/key.asc","TYPE, PREF, ALTID, PID, MEDIATYPE"],["FBURL","Calendar","URI","Free/busy URL","FBURL:https://calendar.com/freebusy/user","TYPE, PREF, ALTID, PID, MEDIATYPE"],["CALADRURI","Calendar","URI","Calendar address URI","CALADRURI:mailto:user@calendar.com","TYPE, PREF, ALTID, PID, MEDIATYPE"],["CALURI","Calendar","URI","Calendar URI","CALURI:https://calendar.com/user","TYPE, PREF, ALTID, PID, MEDIATYPE"],["KIND","Extended","text","Kind of entity (individual, group, org, location)","KIND:individual",""],["XML","Extended","text","XML content","XML:<custom><data>value</data></custom>",""],["CLIENTPIDMAP","Extended","text","Client PID mapping","CLIENTPIDMAP:1;urn:uuid:53e374d9-337e",""],["CREATED","Extended","timestamp","Creation timestamp","CREATED:20250831T131000Z",""],["GRAMGENDER","Extended","text","Grammatical gender","GRAMGENDER:masculine","LANGUAGE"],["LANGUAGE","Extended","language-tag","Language context","LANGUAGE:en-US","TYPE, PREF, ALTID, PID"],["PRONOUNS","Extended","text","Pronouns","PRONOUNS:he/him","LANGUAGE, ALTID, PID"],["SOCIALPROFILE","Extended","URI","Social media profile","SOCIALPROFILE;SERVICE-TYPE=Twitter:https://twitter.com/user","SERVICE-TYPE, USERNAME, TYPE, PREF, ALTID, PID"],["URL","Communication","URI","Website or URL","URL:https://johndoe.com","TYPE, PREF, ALTID, PID"],["SOURCE","Explanatory","URI","Source of vCard data","SOURCE:https://example.com/vcard","TYPE, PREF, ALTID, PID, MEDIATYPE"],["X-SOCIALPROFILE","Extended","URI","Social media profile (legacy)","X-SOCIALPROFILE;TYPE=twitter:https://twitter.com/user","TYPE, SERVICE-TYPE"],["X-AIM","Extended","text","AIM username","X-AIM:username","TYPE"],["X-ICQ","Extended","text","ICQ number","X-ICQ:123456789","TYPE"],["X-JABBER","Extended","text","Jabber/XMPP address","X-JABBER:user@jabber.org","TYPE"],["X-MSN","Extended","text","MSN Messenger address","X-MSN:user@msn.com","TYPE"],["X-YAHOO","Extended","text","Yahoo Messenger address","X-YAHOO:user@yahoo.com","TYPE"],["X-SKYPE","Extended","text","Skype username","X-SKYPE:username","TYPE"],["X-GTALK","Extended","text","Google Talk address","X-GTALK:user@gmail.com","TYPE"],["X-MANAGER","Extended","text","Manager name","X-MANAGER:Jane Smith","TYPE"],["X-ASSISTANT","Extended","text","Assistant name","X-ASSISTANT:Bob Johnson","TYPE"],["X-SPOUSE","Extended","text","Spouse name","X-SPOUSE:Mary Doe","TYPE"],["RELATED","Extended","URI/text","Related person","RELATED;TYPE=spouse:Mary Doe","TYPE, PREF, ALTID, PID, VALUE"],["EXPERTISE","Extended","text","Areas of expertise","EXPERTISE:Software Development","TYPE, LEVEL, INDEX"],["HOBBY","Extended","text","Hobbies","HOBBY:Photography","TYPE, LEVEL, INDEX"],["INTEREST","Extended","text","Interests","INTEREST:Technology","TYPE, LEVEL, INDEX"]];
        $this->insertData($Data[0],array_slice($Data,1));
    }

    public function insertData($head,$records)
    {
        $fullHead = array_merge($head,['created_at','updated_at']); $timestampArray = [now(),now()];
        $recordData = array_map(fn($record) => array_combine($fullHead,array_merge($record,$timestampArray)),$records);
        \Firumon\DigitalBusinessCard\Models\VCardProperty::insert($recordData);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('v_card_property_masters');
    }
};
