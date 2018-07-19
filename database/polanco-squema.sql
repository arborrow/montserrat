-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Generation Time: Jul 18, 2018 at 07:43 PM

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mrhapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE `activity` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'Unique  Other Activity ID',
  `source_record_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'Artificial FK to original transaction (e.g. contribution) IF it is not an Activity. Table can be figured out through activity_type_id, and further through component registry.',
  `activity_type_id` int(10) UNSIGNED NOT NULL DEFAULT '1' COMMENT 'FK to civicrm_option_value.id, that has to be valid, registered activity type.',
  `subject` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'The subject/purpose/short description of the activity.',
  `activity_date_time` datetime DEFAULT NULL COMMENT 'Date and time this activity is scheduled to occur. Formerly named scheduled_date_time.',
  `duration` int(10) UNSIGNED DEFAULT NULL COMMENT 'Planned or actual duration of activity expressed in minutes. Conglomerate of former duration_hours and duration_minutes.',
  `location` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Location of the activity (optional, open text).',
  `phone_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'Phone ID of the number called (optional - used if an existing phone number is selected).',
  `phone_number` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Phone number in case the number does not exist in the civicrm_phone table.',
  `details` longtext COLLATE utf8_unicode_ci COMMENT 'Details about the activity (agenda, notes, etc).',
  `status_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'ID of the status this activity is currently in. Foreign key to civicrm_option_value.',
  `priority_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'ID of the priority given to this activity. Foreign key to civicrm_option_value.',
  `parent_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'Parent meeting ID (if this is a follow-up item). This is not currently implemented',
  `is_test` tinyint(4) DEFAULT '0',
  `medium_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'Activity Medium, Implicit FK to civicrm_option_value where option_group = encounter_medium.',
  `is_auto` tinyint(4) DEFAULT '0',
  `relationship_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'FK to Relationship ID',
  `is_current_revision` tinyint(4) DEFAULT '1',
  `original_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'Activity ID of the first activity record in versioning chain.',
  `result` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Currently being used to store result id for survey activity, FK to option value.',
  `is_deleted` tinyint(4) DEFAULT '0',
  `campaign_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'The campaign for which this activity has been triggered.',
  `engagement_level` int(10) UNSIGNED DEFAULT NULL COMMENT 'Assign a specific level of engagement to this activity. Used for tracking constituents in ladder of engagement.',
  `weight` int(11) DEFAULT NULL,
  `is_star` tinyint(4) DEFAULT '0' COMMENT 'Activity marked as favorite.',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remember_token` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `activity_contact`
--

CREATE TABLE `activity_contact` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'Activity contact id',
  `activity_id` int(10) UNSIGNED NOT NULL COMMENT 'Foreign key to the activity for this record.',
  `contact_id` int(10) UNSIGNED NOT NULL COMMENT 'Foreign key to the contact for this record.',
  `record_type_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'Nature of this contact''s role in the activity: 1 assignee, 2 creator, 3 focus or target.',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remember_token` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `activity_status`
--

CREATE TABLE `activity_status` (
  `id` int(10) UNSIGNED NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '0',
  `is_default` tinyint(1) DEFAULT '0',
  `weight` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `activity_type`
--

CREATE TABLE `activity_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '0',
  `is_default` tinyint(1) DEFAULT '0',
  `weight` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `id` int(10) UNSIGNED NOT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `location_type_id` int(11) DEFAULT NULL,
  `is_primary` int(11) DEFAULT '0',
  `is_billing` int(11) DEFAULT '0',
  `street_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `street_number` int(11) DEFAULT NULL,
  `street_number_suffix` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `street_number_predirectional` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `street_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `street_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `street_number_postdirectional` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `street_unit` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `supplemental_address_1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `supplemental_address_2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `supplemental_address_3` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `county_id` int(11) DEFAULT NULL,
  `state_province_id` int(11) DEFAULT NULL,
  `postal_code_suffix` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postal_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usps_adc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `geo_code_1` double DEFAULT NULL,
  `geo_code_2` double DEFAULT NULL,
  `manual_geo_code` int(11) DEFAULT '0',
  `timezone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `master_id` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bu20180209event`
--

CREATE TABLE `bu20180209event` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `summary` text COLLATE utf8_unicode_ci,
  `description` text COLLATE utf8_unicode_ci,
  `event_type_id` int(10) UNSIGNED DEFAULT '0',
  `participant_listing_id` int(10) UNSIGNED DEFAULT '0',
  `is_public` tinyint(1) DEFAULT '1',
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `is_online_registration` tinyint(1) DEFAULT '0',
  `registration_link_text` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `registration_start_date` datetime DEFAULT NULL,
  `registration-end_date` datetime DEFAULT NULL,
  `max_participants` int(10) UNSIGNED DEFAULT NULL,
  `event_full_text` text COLLATE utf8_unicode_ci,
  `is_monetary` tinyint(1) DEFAULT '0',
  `financial_type_id` int(10) UNSIGNED DEFAULT NULL,
  `payment_processor` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_map` tinyint(1) DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '0',
  `fee_label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_show_location` tinyint(1) DEFAULT '1',
  `loc_block_id` int(10) UNSIGNED DEFAULT NULL,
  `default_role_id` int(10) UNSIGNED DEFAULT '1',
  `intro_text` text COLLATE utf8_unicode_ci,
  `footer_text` text COLLATE utf8_unicode_ci,
  `confirm_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `confirm_text` text COLLATE utf8_unicode_ci,
  `confirm_footer_text` text COLLATE utf8_unicode_ci,
  `is_email_confirm` tinyint(1) DEFAULT '0',
  `confirm_email_text` text COLLATE utf8_unicode_ci,
  `confirm_from_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `confirm_from_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cc_confirm` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bc_confirm` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `default_fee_id` int(10) UNSIGNED DEFAULT NULL,
  `default_discount_fee_id` int(10) UNSIGNED DEFAULT NULL,
  `thankyou_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `thankyou_text` text COLLATE utf8_unicode_ci,
  `thankyou_footer_text` text COLLATE utf8_unicode_ci,
  `is_pay_later` tinyint(1) DEFAULT '0',
  `pay_later_text` text COLLATE utf8_unicode_ci,
  `pay_later_receipt` text COLLATE utf8_unicode_ci,
  `is_partial_payment` tinyint(1) DEFAULT '0',
  `initial_amount_label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `initial_amount_help_text` text COLLATE utf8_unicode_ci,
  `min_initial_amount` decimal(20,2) DEFAULT NULL,
  `is_multiple_registrations` tinyint(1) DEFAULT '0',
  `allow_same_participant_emails` tinyint(1) DEFAULT '0',
  `has_waitlist` tinyint(1) DEFAULT NULL,
  `requires_approval` tinyint(1) DEFAULT NULL,
  `expiration_time` int(10) UNSIGNED DEFAULT NULL,
  `waitlist_text` text COLLATE utf8_unicode_ci,
  `approval_req_text` text COLLATE utf8_unicode_ci,
  `is_template` tinyint(1) DEFAULT '0',
  `template_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_id` int(10) UNSIGNED DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `currency` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `campaign_id` int(10) UNSIGNED DEFAULT NULL,
  `is_share` tinyint(1) DEFAULT '1',
  `parent_event_id` int(10) UNSIGNED DEFAULT NULL,
  `slot_label_id` int(10) UNSIGNED DEFAULT NULL,
  `retreat_id` int(10) UNSIGNED DEFAULT NULL,
  `idnumber` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'idnumber',
  `director_id` int(10) UNSIGNED DEFAULT NULL,
  `innkeeper_id` int(10) UNSIGNED DEFAULT NULL,
  `assistant_id` int(10) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `ppd_id` int(11) DEFAULT NULL,
  `calendar_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bu20180328Donations`
--

CREATE TABLE `bu20180328Donations` (
  `Donation ID` int(11) DEFAULT NULL,
  `Donor ID` int(11) DEFAULT NULL,
  `Donation Description` varchar(100) DEFAULT NULL,
  `Donation Date` datetime DEFAULT NULL,
  `DonationAmount` float DEFAULT NULL,
  `Donation Install` float DEFAULT NULL,
  `Terms` text,
  `Start Date` datetime DEFAULT NULL,
  `End Date` datetime DEFAULT NULL,
  `Payment Description` varchar(100) DEFAULT NULL,
  `Retreat ID` int(11) DEFAULT NULL,
  `Notes` text,
  `Notes1` text,
  `Notice` char(1) DEFAULT NULL,
  `Arrupe Donation Description` varchar(100) DEFAULT NULL,
  `Target Amount` int(11) DEFAULT NULL,
  `Donation Type ID` int(11) DEFAULT NULL,
  `Thank You` char(1) DEFAULT NULL,
  `AGC Donation Description` varchar(100) DEFAULT NULL,
  `Pledge` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bu20180328Donors`
--

CREATE TABLE `bu20180328Donors` (
  `donor_id` int(11) DEFAULT NULL,
  `FName` varchar(80) CHARACTER SET utf8 DEFAULT NULL,
  `MInitial` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `LName` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `Address` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `Address2` varchar(90) CHARACTER SET utf8 DEFAULT NULL,
  `City` varchar(90) CHARACTER SET utf8 DEFAULT NULL,
  `State` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
  `Zip` varchar(22) CHARACTER SET utf8 DEFAULT NULL,
  `NickName` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `SpouseName` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
  `HomePhone` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
  `WorkPhone` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
  `EMailAddress` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `FaxNumber` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
  `worker_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `phase_id` int(11) DEFAULT NULL,
  `age_id` int(11) DEFAULT NULL,
  `occup_id` int(11) DEFAULT NULL,
  `church_id` int(11) DEFAULT NULL,
  `salut_id` int(11) DEFAULT NULL,
  `NameEnd` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `Gender` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
  `donation_type_id` int(11) DEFAULT NULL,
  `DonationID` int(11) DEFAULT NULL,
  `retreat_id` int(11) DEFAULT NULL,
  `retreat_date` datetime DEFAULT NULL,
  `First Visit` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `Big Donor` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `Old Donor` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `New Date ID` int(11) DEFAULT NULL,
  `NotAvailable` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `Note` varchar(80) CHARACTER SET utf8 DEFAULT NULL,
  `CampLetterSent` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `DateLetSent` datetime DEFAULT NULL,
  `AdventDonor` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `Church` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `Elderhostel` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `Deceased` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `Spouse` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `RoomNum` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
  `Cancel` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `ReqRemoval` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `Note1` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `Note2` text CHARACTER SET utf8,
  `BoardMember` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `NoticeSend` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `Captain` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `Knights` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `CaptainSince` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `ParkCityClub` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `SpeedwayClub` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `DonatedWillNotAttend` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `PartyMailList` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `SpiritDirect` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `KofC Grand Councils` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `Hispanic` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `October Dinner Meeting` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `Board Advisor` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `cell_phone` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `Emergency Contact Num` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `Emergency Name` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `Emergency Contact Num2` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `St Rita Spiritual Exercises` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `sort_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort_name_count` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bu20180402_donations_payment`
--

CREATE TABLE `bu20180402_donations_payment` (
  `payment_id` int(11) NOT NULL,
  `donation_id` int(11) DEFAULT NULL,
  `payment_amount` decimal(9,2) DEFAULT NULL,
  `payment_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `payment_description` varchar(23) DEFAULT NULL,
  `cknumber` varchar(17) DEFAULT NULL,
  `ccnumber` varchar(21) DEFAULT NULL,
  `expire_date` datetime DEFAULT NULL,
  `authorization_number` varchar(8) DEFAULT NULL,
  `note` varchar(100) DEFAULT NULL,
  `ty_letter_sent` varchar(1) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `capabilities`
--

CREATE TABLE `capabilities` (
  `id` int(10) UNSIGNED NOT NULL,
  `capability` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `component` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `captain_retreat`
--

CREATE TABLE `captain_retreat` (
  `contact_id` int(10) UNSIGNED NOT NULL,
  `event_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `civicrm_participant_status_type`
--

CREATE TABLE `civicrm_participant_status_type` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'unique participant status type id',
  `name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'non-localized name of the status type',
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'localized label for display of this status type',
  `class` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'the general group of status type this one belongs to',
  `is_reserved` tinyint(4) DEFAULT NULL COMMENT 'whether this is a status type required by the system',
  `is_active` tinyint(4) DEFAULT '1' COMMENT 'whether this status type is active',
  `is_counted` tinyint(4) DEFAULT NULL COMMENT 'whether this status type is counted against event size limit',
  `weight` int(10) UNSIGNED NOT NULL COMMENT 'controls sort order',
  `visibility_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'whether the status type is visible to the public, an implicit foreign key to option_value.value related to the `visibility` option_group'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(10) UNSIGNED NOT NULL,
  `contact_type` int(11) DEFAULT NULL,
  `subcontact_type` int(11) DEFAULT NULL,
  `do_not_email` tinyint(1) NOT NULL DEFAULT '0',
  `do_not_phone` tinyint(1) NOT NULL DEFAULT '0',
  `do_not_mail` tinyint(1) NOT NULL DEFAULT '0',
  `do_not_sms` tinyint(1) NOT NULL DEFAULT '0',
  `do_not_trade` tinyint(1) NOT NULL DEFAULT '0',
  `is_opt_out` tinyint(1) NOT NULL DEFAULT '0',
  `legal_identifier` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `external_identifier` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nick_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `legal_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_URL` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `preferred_communication_method` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `preferred_language` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `preferred_mail_format` enum('Text','HTML','Both') COLLATE utf8_unicode_ci DEFAULT NULL,
  `hash` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `api_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `source` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `middle_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `prefix_id` int(11) DEFAULT NULL,
  `suffix_id` int(11) DEFAULT NULL,
  `email_greeting_id` int(11) DEFAULT NULL,
  `email_greeting_custom` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_greeting_display` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postal_greeting_id` int(11) DEFAULT NULL,
  `postal_greeting_custom` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postal_greeting_display` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `addressee_id` int(11) DEFAULT NULL,
  `addressee_greeting_custom` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `addressee_greeting_display` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `job_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender_id` int(11) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `is_deceased` tinyint(1) DEFAULT NULL,
  `deceased_date` date DEFAULT NULL,
  `household_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `primary_contact_id` int(11) DEFAULT NULL,
  `organization_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sic_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_unique_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `employer_id` int(11) DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT '0',
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified_date` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `ethnicity_id` int(10) UNSIGNED DEFAULT NULL,
  `religion_id` int(10) UNSIGNED DEFAULT NULL,
  `occupation_id` int(10) UNSIGNED DEFAULT NULL,
  `sort_name_count` int(10) UNSIGNED DEFAULT NULL,
  `ppd_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_languages`
--

CREATE TABLE `contact_languages` (
  `id` int(10) UNSIGNED NOT NULL,
  `contact_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_referral`
--

CREATE TABLE `contact_referral` (
  `contact_id` int(11) NOT NULL,
  `referral_id` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_type`
--

CREATE TABLE `contact_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `image_URL` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `is_reserved` tinyint(1) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contribution`
--

CREATE TABLE `contribution` (
  `id` int(10) UNSIGNED NOT NULL,
  `contact_id` int(10) UNSIGNED NOT NULL,
  `financial_type_id` int(10) UNSIGNED DEFAULT NULL,
  `contribution_page_id` int(10) UNSIGNED DEFAULT NULL,
  `payment_instrument_id` int(10) UNSIGNED DEFAULT NULL,
  `receive_date` datetime DEFAULT NULL,
  `non_deductible_amount` decimal(20,2) DEFAULT '0.00',
  `total_amount` decimal(20,2) NOT NULL,
  `fee_amount` decimal(20,2) DEFAULT NULL,
  `net_amount` decimal(20,2) DEFAULT NULL,
  `trxn_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `invoice_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `currency` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cancel_date` datetime DEFAULT NULL,
  `cancel_reason` text COLLATE utf8_unicode_ci,
  `receipt_date` datetime DEFAULT NULL,
  `thankyou_date` datetime DEFAULT NULL,
  `source` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `amount_level` text COLLATE utf8_unicode_ci,
  `contribution_recur_id` int(10) UNSIGNED DEFAULT NULL,
  `honor_contact_id` int(10) UNSIGNED DEFAULT NULL,
  `is_test` tinyint(1) DEFAULT '0',
  `is_pay_later` tinyint(1) DEFAULT '0',
  `contribution_status_id` int(10) UNSIGNED DEFAULT '1',
  `honor_type_id` int(10) UNSIGNED DEFAULT NULL,
  `address_id` int(10) UNSIGNED DEFAULT NULL,
  `check_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `campaign_id` int(10) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `iso_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_format_id` int(11) DEFAULT NULL,
  `idd_prefix` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ndd_prefix` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `region_id` int(11) DEFAULT NULL,
  `is_province_abbreviated` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `county`
--

CREATE TABLE `county` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `abbreviation` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state_province_id` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dioceses`
--

CREATE TABLE `dioceses` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `zip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fax` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `webpage` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bishop_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `notes` text COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `domain`
--

CREATE TABLE `domain` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `config_backend` text COLLATE utf8_unicode_ci,
  `version` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_id` int(10) UNSIGNED DEFAULT NULL,
  `locales` text COLLATE utf8_unicode_ci,
  `locale_custom_strings` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Donations`
--

CREATE TABLE `Donations` (
  `donation_id` int(11) NOT NULL,
  `donor_id` int(11) DEFAULT NULL,
  `donation_description` varchar(100) DEFAULT NULL,
  `donation_date` datetime DEFAULT NULL,
  `donation_amount` float DEFAULT NULL,
  `donation_install` float DEFAULT NULL,
  `terms` text,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `payment_description` varchar(100) DEFAULT NULL,
  `retreat_id` int(11) DEFAULT NULL,
  `Notes` text,
  `Notes1` text,
  `Notice` char(1) DEFAULT NULL,
  `Arrupe Donation Description` varchar(100) DEFAULT NULL,
  `Target Amount` int(11) DEFAULT NULL,
  `Donation Type ID` int(11) DEFAULT NULL,
  `Thank You` char(1) DEFAULT NULL,
  `AGC Donation Description` varchar(100) DEFAULT NULL,
  `Pledge` varchar(50) DEFAULT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `ppd_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Donations_payment`
--

CREATE TABLE `Donations_payment` (
  `payment_id` int(11) NOT NULL,
  `donation_id` int(11) DEFAULT NULL,
  `payment_amount` decimal(9,2) DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL,
  `payment_description` varchar(23) DEFAULT NULL,
  `cknumber` varchar(17) DEFAULT NULL,
  `ccnumber` varchar(21) DEFAULT NULL,
  `expire_date` datetime DEFAULT NULL,
  `authorization_number` varchar(8) DEFAULT NULL,
  `note` varchar(100) DEFAULT NULL,
  `ty_letter_sent` varchar(1) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `donation_type`
--

CREATE TABLE `donation_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `is_default` tinyint(1) DEFAULT '0',
  `is_reserved` tinyint(1) DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Donors`
--

CREATE TABLE `Donors` (
  `donor_id` int(11) DEFAULT NULL,
  `FName` varchar(80) CHARACTER SET utf8 DEFAULT NULL,
  `MInitial` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `LName` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `Address` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `Address2` varchar(90) CHARACTER SET utf8 DEFAULT NULL,
  `City` varchar(90) CHARACTER SET utf8 DEFAULT NULL,
  `State` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
  `Zip` varchar(22) CHARACTER SET utf8 DEFAULT NULL,
  `NickName` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `SpouseName` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
  `HomePhone` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
  `WorkPhone` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
  `EMailAddress` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `FaxNumber` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
  `worker_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `phase_id` int(11) DEFAULT NULL,
  `age_id` int(11) DEFAULT NULL,
  `occup_id` int(11) DEFAULT NULL,
  `church_id` int(11) DEFAULT NULL,
  `salut_id` int(11) DEFAULT NULL,
  `NameEnd` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `Gender` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
  `donation_type_id` int(11) DEFAULT NULL,
  `DonationID` int(11) DEFAULT NULL,
  `retreat_id` int(11) DEFAULT NULL,
  `retreat_date` datetime DEFAULT NULL,
  `First Visit` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `Big Donor` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `Old Donor` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `New Date ID` int(11) DEFAULT NULL,
  `NotAvailable` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `Note` varchar(80) CHARACTER SET utf8 DEFAULT NULL,
  `CampLetterSent` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `DateLetSent` datetime DEFAULT NULL,
  `AdventDonor` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `Church` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `Elderhostel` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `Deceased` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `Spouse` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `RoomNum` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
  `Cancel` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `ReqRemoval` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `Note1` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `Note2` text CHARACTER SET utf8,
  `BoardMember` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `NoticeSend` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `Captain` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `Knights` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `CaptainSince` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `ParkCityClub` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `SpeedwayClub` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `DonatedWillNotAttend` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `PartyMailList` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `SpiritDirect` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `KofC Grand Councils` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `Hispanic` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `October Dinner Meeting` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `Board Advisor` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `cell_phone` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `Emergency Contact Num` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `Emergency Name` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `Emergency Contact Num2` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `St Rita Spiritual Exercises` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `sort_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort_name_count` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email`
--

CREATE TABLE `email` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `location_type_id` int(11) DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_primary` tinyint(1) DEFAULT '0',
  `is_billing` tinyint(1) DEFAULT '0',
  `on_hold` tinyint(1) NOT NULL DEFAULT '0',
  `is_bulkmail` tinyint(1) NOT NULL DEFAULT '0',
  `hold_date` date DEFAULT NULL,
  `reset_date` date DEFAULT NULL,
  `signature_text` text COLLATE utf8_unicode_ci,
  `signature_html` text COLLATE utf8_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emergency_contact`
--

CREATE TABLE `emergency_contact` (
  `id` int(10) UNSIGNED NOT NULL,
  `contact_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `relationship` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_alternate` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ethnicities`
--

CREATE TABLE `ethnicities` (
  `id` int(10) UNSIGNED NOT NULL,
  `ethnicity` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `summary` text COLLATE utf8_unicode_ci,
  `description` text COLLATE utf8_unicode_ci,
  `event_type_id` int(10) UNSIGNED DEFAULT '0',
  `participant_listing_id` int(10) UNSIGNED DEFAULT '0',
  `is_public` tinyint(1) DEFAULT '1',
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `is_online_registration` tinyint(1) DEFAULT '0',
  `registration_link_text` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `registration_start_date` datetime DEFAULT NULL,
  `registration-end_date` datetime DEFAULT NULL,
  `max_participants` int(10) UNSIGNED DEFAULT NULL,
  `event_full_text` text COLLATE utf8_unicode_ci,
  `is_monetary` tinyint(1) DEFAULT '0',
  `financial_type_id` int(10) UNSIGNED DEFAULT NULL,
  `payment_processor` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_map` tinyint(1) DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '0',
  `fee_label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_show_location` tinyint(1) DEFAULT '1',
  `loc_block_id` int(10) UNSIGNED DEFAULT NULL,
  `default_role_id` int(10) UNSIGNED DEFAULT '1',
  `intro_text` text COLLATE utf8_unicode_ci,
  `footer_text` text COLLATE utf8_unicode_ci,
  `confirm_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `confirm_text` text COLLATE utf8_unicode_ci,
  `confirm_footer_text` text COLLATE utf8_unicode_ci,
  `is_email_confirm` tinyint(1) DEFAULT '0',
  `confirm_email_text` text COLLATE utf8_unicode_ci,
  `confirm_from_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `confirm_from_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cc_confirm` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bc_confirm` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `default_fee_id` int(10) UNSIGNED DEFAULT NULL,
  `default_discount_fee_id` int(10) UNSIGNED DEFAULT NULL,
  `thankyou_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `thankyou_text` text COLLATE utf8_unicode_ci,
  `thankyou_footer_text` text COLLATE utf8_unicode_ci,
  `is_pay_later` tinyint(1) DEFAULT '0',
  `pay_later_text` text COLLATE utf8_unicode_ci,
  `pay_later_receipt` text COLLATE utf8_unicode_ci,
  `is_partial_payment` tinyint(1) DEFAULT '0',
  `initial_amount_label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `initial_amount_help_text` text COLLATE utf8_unicode_ci,
  `min_initial_amount` decimal(20,2) DEFAULT NULL,
  `is_multiple_registrations` tinyint(1) DEFAULT '0',
  `allow_same_participant_emails` tinyint(1) DEFAULT '0',
  `has_waitlist` tinyint(1) DEFAULT NULL,
  `requires_approval` tinyint(1) DEFAULT NULL,
  `expiration_time` int(10) UNSIGNED DEFAULT NULL,
  `waitlist_text` text COLLATE utf8_unicode_ci,
  `approval_req_text` text COLLATE utf8_unicode_ci,
  `is_template` tinyint(1) DEFAULT '0',
  `template_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_id` int(10) UNSIGNED DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `currency` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `campaign_id` int(10) UNSIGNED DEFAULT NULL,
  `is_share` tinyint(1) DEFAULT '1',
  `parent_event_id` int(10) UNSIGNED DEFAULT NULL,
  `slot_label_id` int(10) UNSIGNED DEFAULT NULL,
  `retreat_id` int(10) UNSIGNED DEFAULT NULL,
  `idnumber` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'idnumber',
  `director_id` int(10) UNSIGNED DEFAULT NULL,
  `innkeeper_id` int(10) UNSIGNED DEFAULT NULL,
  `assistant_id` int(10) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `ppd_id` int(11) DEFAULT NULL,
  `calendar_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_type`
--

CREATE TABLE `event_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `is_default` tinyint(1) DEFAULT '0',
  `is_reserved` tinyint(1) DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `file`
--

CREATE TABLE `file` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `file_type_id` int(11) DEFAULT NULL,
  `mime_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `uri` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `document` mediumblob,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `upload_date` datetime DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `entity` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entity_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `file_type`
--

CREATE TABLE `file_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `is_default` tinyint(1) DEFAULT '0',
  `is_reserved` tinyint(1) DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `financial_account`
--

CREATE TABLE `financial_account` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contact_id` int(10) UNSIGNED DEFAULT NULL,
  `financial_account_type_id` int(10) UNSIGNED NOT NULL DEFAULT '3',
  `accounting_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_type_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `is_header_account` tinyint(1) DEFAULT '0',
  `is_deductible` tinyint(1) DEFAULT '1',
  `is_tax` tinyint(1) DEFAULT '0',
  `tax_rate` decimal(10,8) DEFAULT NULL,
  `is_reserved` tinyint(1) DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '0',
  `is_default` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `financial_trxn`
--

CREATE TABLE `financial_trxn` (
  `id` int(10) UNSIGNED NOT NULL,
  `from_financial_account_id` int(10) UNSIGNED DEFAULT NULL,
  `to_financial_account_id` int(10) UNSIGNED DEFAULT NULL,
  `trxn_date` datetime NOT NULL,
  `total_amount` decimal(20,2) DEFAULT NULL,
  `fee_amount` decimal(20,2) DEFAULT NULL,
  `net_amount` decimal(20,2) DEFAULT NULL,
  `currency` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `trxn_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `trxn_result_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status_id` int(10) UNSIGNED DEFAULT NULL,
  `payment_processor_id` int(10) UNSIGNED DEFAULT NULL,
  `payment_instrument_id` int(10) UNSIGNED DEFAULT NULL,
  `check_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gender`
--

CREATE TABLE `gender` (
  `id` int(10) UNSIGNED NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '0',
  `is_default` tinyint(1) DEFAULT '0',
  `weight` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `group`
--

CREATE TABLE `group` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `source` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `saved_search_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `visibility` enum('User and User Admin Only','Public Pages') COLLATE utf8_unicode_ci DEFAULT 'User and User Admin Only',
  `where_clause` text COLLATE utf8_unicode_ci,
  `select_tables` text COLLATE utf8_unicode_ci,
  `where_tables` text COLLATE utf8_unicode_ci,
  `group_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cache_date` timestamp NULL DEFAULT NULL,
  `refresh_date` timestamp NULL DEFAULT NULL,
  `parents` text COLLATE utf8_unicode_ci,
  `children` text COLLATE utf8_unicode_ci,
  `is_hidden` tinyint(1) DEFAULT '0',
  `is_reserved` tinyint(1) DEFAULT '0',
  `created_id` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `group_contact`
--

CREATE TABLE `group_contact` (
  `id` int(10) UNSIGNED NOT NULL,
  `group_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL,
  `status` enum('Added','Removed','Pending') COLLATE utf8_unicode_ci DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `email_id` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jesuits`
--

CREATE TABLE `jesuits` (
  `id` int(10) UNSIGNED NOT NULL,
  `person_id` int(11) NOT NULL,
  `community_id` int(11) NOT NULL,
  `province_id` int(11) NOT NULL,
  `is_ordained` tinyint(1) DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `language`
--

CREATE TABLE `language` (
  `id` int(10) UNSIGNED NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(1) DEFAULT '0',
  `is_default` tinyint(1) DEFAULT '0',
  `weight` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `occupancy` int(11) DEFAULT NULL,
  `notes` mediumtext COLLATE utf8_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `location_type`
--

CREATE TABLE `location_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `vcard_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `is_reserved` tinyint(1) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `mailgun_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mailgun_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `storage_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `from` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `from_id` int(10) UNSIGNED DEFAULT NULL,
  `to` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `to_id` int(10) UNSIGNED DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `body` text COLLATE utf8_unicode_ci,
  `is_processed` tinyint(1) DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `message_attachments`
--

CREATE TABLE `message_attachments` (
  `id` int(10) UNSIGNED NOT NULL,
  `mailgun_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `attachment_id` int(10) UNSIGNED DEFAULT NULL,
  `mailgun_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `note`
--

CREATE TABLE `note` (
  `id` int(10) UNSIGNED NOT NULL,
  `entity_table` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `entity_id` int(11) NOT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `contact_id` int(11) DEFAULT NULL,
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `subject` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `privacy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `occupation_list`
--

CREATE TABLE `occupation_list` (
  `OCC_CODE` varchar(15) DEFAULT NULL,
  `OCC_TITLE` varchar(105) DEFAULT NULL,
  `OCC_GROUP` varchar(15) DEFAULT NULL,
  `TOT_EMP` varchar(15) DEFAULT NULL,
  `EMP_PRSE` decimal(3,1) DEFAULT NULL,
  `H_MEAN` varchar(15) DEFAULT NULL,
  `A_MEAN` varchar(15) DEFAULT NULL,
  `MEAN_PRSE` decimal(3,1) DEFAULT NULL,
  `H_MEDIAN` varchar(15) DEFAULT NULL,
  `A_MEDIAN` varchar(15) DEFAULT NULL,
  `ANNUAL` varchar(15) DEFAULT NULL,
  `HOURLY` varchar(15) DEFAULT NULL,
  `ocuupation_id` int(11) DEFAULT NULL COMMENT 'fk to ppd occupation id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='data from http://www.bls.gov/oes/special.requests/oesm15nat.zip';

-- --------------------------------------------------------

--
-- Table structure for table `parishes`
--

CREATE TABLE `parishes` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `zip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fax` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `webpage` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `diocese_id` int(11) NOT NULL,
  `pastor_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `notes` text COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `participant`
--

CREATE TABLE `participant` (
  `id` int(10) UNSIGNED NOT NULL,
  `contact_id` int(10) UNSIGNED NOT NULL,
  `event_id` int(10) UNSIGNED NOT NULL,
  `status_id` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `role_id` int(10) UNSIGNED DEFAULT '5',
  `register_date` datetime DEFAULT NULL,
  `source` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fee_level` text COLLATE utf8_unicode_ci,
  `is_test` tinyint(1) DEFAULT '0',
  `is_pay_later` tinyint(1) DEFAULT '0',
  `fee_amount` decimal(20,2) DEFAULT NULL,
  `registered_by_id` int(10) UNSIGNED DEFAULT NULL,
  `discount_id` int(10) UNSIGNED DEFAULT NULL,
  `fee_currency` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `campaign_id` int(10) UNSIGNED DEFAULT NULL,
  `discount_amount` int(10) UNSIGNED DEFAULT NULL,
  `cart_id` int(10) UNSIGNED DEFAULT NULL,
  `must_wait` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `registration_confirm_date` datetime DEFAULT NULL,
  `attendance_confirm_date` datetime DEFAULT NULL,
  `confirmed_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8_unicode_ci,
  `deposit` decimal(7,2) NOT NULL DEFAULT '0.00',
  `canceled_at` datetime DEFAULT NULL,
  `arrived_at` datetime DEFAULT NULL,
  `departed_at` datetime DEFAULT NULL,
  `room_id` int(10) UNSIGNED DEFAULT NULL,
  `donation_id` int(10) DEFAULT NULL,
  `ppd_source` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `participant_payment`
--

CREATE TABLE `participant_payment` (
  `id` int(10) UNSIGNED NOT NULL,
  `participant_id` int(10) UNSIGNED NOT NULL,
  `contribution_id` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `participant_role_type`
--

CREATE TABLE `participant_role_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `option_group_id` int(10) UNSIGNED NOT NULL DEFAULT '13',
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `grouping` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `filter` int(10) UNSIGNED DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT '0',
  `weight` int(10) UNSIGNED NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `is_optgroup` tinyint(1) DEFAULT '0',
  `is_reserved` tinyint(1) DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `component_id` int(10) UNSIGNED DEFAULT NULL,
  `domain_id` int(10) UNSIGNED DEFAULT NULL,
  `visibility_id` int(10) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `participant_status_type`
--

CREATE TABLE `participant_status_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` text COLLATE utf8_unicode_ci,
  `class` enum('Positive','Pending','Waiting','Negative') COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_reserved` tinyint(1) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `is_counted` tinyint(1) DEFAULT NULL,
  `weight` int(10) UNSIGNED NOT NULL,
  `visibility_id` int(10) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_processor`
--

CREATE TABLE `payment_processor` (
  `id` int(10) UNSIGNED NOT NULL,
  `domain_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_processor_type_id` int(10) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT NULL,
  `is_test` tinyint(1) DEFAULT NULL,
  `user_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `signature` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url_site` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url_api` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url_recur` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url_button` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `class_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_mode` int(10) UNSIGNED NOT NULL,
  `is_recur` tinyint(1) DEFAULT NULL,
  `payment_type` int(10) UNSIGNED DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_processor_type`
--

CREATE TABLE `payment_processor_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(127) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT NULL,
  `user_name_label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `signature_label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject_label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `class_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url_site_default` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url_api_default` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url_recur_default` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url_button_default` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url_site_test_default` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url_api_test_default` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url_button_test_default` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_mode` int(10) UNSIGNED NOT NULL,
  `is_recur` tinyint(1) DEFAULT NULL,
  `payment_type` int(10) UNSIGNED DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `persons`
--

CREATE TABLE `persons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `middlename` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `suffix` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nickname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'TX',
  `zip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'USA',
  `homephone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `workphone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobilephone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `faxphone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `emergencycontactname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `emergencycontactphone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `emergencycontactphone2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `parish_id` int(10) UNSIGNED DEFAULT NULL,
  `ethnicity` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'Unspecified',
  `languages` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'English',
  `dietary` text COLLATE utf8_unicode_ci,
  `medical` text COLLATE utf8_unicode_ci,
  `roompreference` text COLLATE utf8_unicode_ci,
  `notes` mediumtext COLLATE utf8_unicode_ci,
  `is_donor` tinyint(1) DEFAULT '1',
  `is_retreatant` tinyint(1) DEFAULT '1',
  `is_director` tinyint(1) DEFAULT '0',
  `is_innkeeper` tinyint(1) DEFAULT '0',
  `is_assistant` tinyint(1) DEFAULT '0',
  `is_captain` tinyint(1) DEFAULT '0',
  `is_staff` tinyint(1) DEFAULT '0',
  `is_volunteer` tinyint(1) DEFAULT '0',
  `is_board` tinyint(1) DEFAULT '0',
  `is_pastor` tinyint(1) DEFAULT '0',
  `is_bishop` tinyint(1) DEFAULT '0',
  `is_catholic` tinyint(1) DEFAULT '1',
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_deceased` tinyint(1) NOT NULL DEFAULT '0',
  `donor_id` int(11) DEFAULT NULL,
  `is_formerboard` tinyint(1) DEFAULT '0',
  `is_jesuit` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `phone`
--

CREATE TABLE `phone` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `location_type_id` int(11) DEFAULT NULL,
  `is_primary` int(11) NOT NULL DEFAULT '0',
  `is_billing` int(11) NOT NULL DEFAULT '0',
  `mobile_provider_id` int(11) DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_ext` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_numeric` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_type_id` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `phone_type` enum('Phone','Mobile','Fax','Pager','Voicemail','Other') COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile_provider` enum('Sprint','Verizon','Cingular','AT&T','T-Mobile','MetroPCS','US Cellular','Other') COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pma__bookmark`
--

CREATE TABLE `pma__bookmark` (
  `id` int(11) NOT NULL,
  `dbase` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `user` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `label` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `query` text COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Bookmarks';

-- --------------------------------------------------------

--
-- Table structure for table `pma__central_columns`
--

CREATE TABLE `pma__central_columns` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_type` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_length` text COLLATE utf8_bin,
  `col_collation` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_isNull` tinyint(1) NOT NULL,
  `col_extra` varchar(255) COLLATE utf8_bin DEFAULT '',
  `col_default` text COLLATE utf8_bin
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Central list of columns';

-- --------------------------------------------------------

--
-- Table structure for table `pma__column_info`
--

CREATE TABLE `pma__column_info` (
  `id` int(5) UNSIGNED NOT NULL,
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `column_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `comment` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `mimetype` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `transformation` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `transformation_options` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `input_transformation` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `input_transformation_options` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Column information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__designer_settings`
--

CREATE TABLE `pma__designer_settings` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `settings_data` text COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Settings related to Designer';

-- --------------------------------------------------------

--
-- Table structure for table `pma__export_templates`
--

CREATE TABLE `pma__export_templates` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `export_type` varchar(10) COLLATE utf8_bin NOT NULL,
  `template_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `template_data` text COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved export templates';

-- --------------------------------------------------------

--
-- Table structure for table `pma__favorite`
--

CREATE TABLE `pma__favorite` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `tables` text COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Favorite tables';

-- --------------------------------------------------------

--
-- Table structure for table `pma__history`
--

CREATE TABLE `pma__history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `db` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `timevalue` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sqlquery` text COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='SQL history for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__navigationhiding`
--

CREATE TABLE `pma__navigationhiding` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `item_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `item_type` varchar(64) COLLATE utf8_bin NOT NULL,
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Hidden items of navigation tree';

-- --------------------------------------------------------

--
-- Table structure for table `pma__pdf_pages`
--

CREATE TABLE `pma__pdf_pages` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `page_nr` int(10) UNSIGNED NOT NULL,
  `page_descr` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='PDF relation pages for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__recent`
--

CREATE TABLE `pma__recent` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `tables` text COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Recently accessed tables';

-- --------------------------------------------------------

--
-- Table structure for table `pma__relation`
--

CREATE TABLE `pma__relation` (
  `master_db` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `master_table` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `master_field` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `foreign_db` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `foreign_table` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `foreign_field` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Relation table';

-- --------------------------------------------------------

--
-- Table structure for table `pma__savedsearches`
--

CREATE TABLE `pma__savedsearches` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `search_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `search_data` text COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved searches';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_coords`
--

CREATE TABLE `pma__table_coords` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `pdf_page_number` int(11) NOT NULL DEFAULT '0',
  `x` float UNSIGNED NOT NULL DEFAULT '0',
  `y` float UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table coordinates for phpMyAdmin PDF output';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_info`
--

CREATE TABLE `pma__table_info` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `display_field` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_uiprefs`
--

CREATE TABLE `pma__table_uiprefs` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `prefs` text COLLATE utf8_bin NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tables'' UI preferences';

-- --------------------------------------------------------

--
-- Table structure for table `pma__tracking`
--

CREATE TABLE `pma__tracking` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `version` int(10) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `schema_snapshot` text COLLATE utf8_bin NOT NULL,
  `schema_sql` text COLLATE utf8_bin,
  `data_sql` longtext COLLATE utf8_bin,
  `tracking` set('UPDATE','REPLACE','INSERT','DELETE','TRUNCATE','CREATE DATABASE','ALTER DATABASE','DROP DATABASE','CREATE TABLE','ALTER TABLE','RENAME TABLE','DROP TABLE','CREATE INDEX','DROP INDEX','CREATE VIEW','ALTER VIEW','DROP VIEW') COLLATE utf8_bin DEFAULT NULL,
  `tracking_active` int(1) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Database changes tracking for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__userconfig`
--

CREATE TABLE `pma__userconfig` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `timevalue` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `config_data` text COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User preferences storage for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__usergroups`
--

CREATE TABLE `pma__usergroups` (
  `usergroup` varchar(64) COLLATE utf8_bin NOT NULL,
  `tab` varchar(64) COLLATE utf8_bin NOT NULL,
  `allowed` enum('Y','N') COLLATE utf8_bin NOT NULL DEFAULT 'N'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User groups with configured menu items';

-- --------------------------------------------------------

--
-- Table structure for table `pma__users`
--

CREATE TABLE `pma__users` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `usergroup` varchar(64) COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Users and their assignments to user groups';

-- --------------------------------------------------------

--
-- Table structure for table `ppd_occupations`
--

CREATE TABLE `ppd_occupations` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `occ_code` varchar(15) DEFAULT NULL COMMENT 'fk to occupation_list'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `prefix`
--

CREATE TABLE `prefix` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `referral`
--

CREATE TABLE `referral` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(1) DEFAULT '0',
  `is_default` tinyint(1) DEFAULT '0',
  `weight` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

CREATE TABLE `registrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `retreatant_id` int(10) UNSIGNED NOT NULL,
  `retreat_id` int(10) UNSIGNED NOT NULL,
  `start` timestamp NULL DEFAULT NULL,
  `end` timestamp NULL DEFAULT NULL,
  `register` timestamp NULL DEFAULT NULL,
  `confirmregister` timestamp NULL DEFAULT NULL,
  `confirmattend` timestamp NULL DEFAULT NULL,
  `confirmedby` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8_unicode_ci NOT NULL,
  `deposit` decimal(7,2) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `canceled_at` timestamp NULL DEFAULT NULL,
  `arrived_at` timestamp NULL DEFAULT NULL,
  `departed_at` timestamp NULL DEFAULT NULL,
  `room_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `relationship`
--

CREATE TABLE `relationship` (
  `id` int(10) UNSIGNED NOT NULL,
  `contact_id_a` int(11) NOT NULL,
  `contact_id_b` int(11) NOT NULL,
  `relationship_type_id` int(11) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_permission_a_b` tinyint(1) DEFAULT NULL,
  `is_permission_b_a` tinyint(1) DEFAULT NULL,
  `case_id` int(11) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `relationship_type`
--

CREATE TABLE `relationship_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `name_a_b` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name_b_a` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `label_a_b` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `label_b_a` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `contact_type_a` enum('Individual','Organization','Household') COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_type_b` enum('Individual','Organization','Household') COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_sub_type_a` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_sub_type_b` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_reserved` tinyint(1) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `occupancy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `religion`
--

CREATE TABLE `religion` (
  `id` int(10) UNSIGNED NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(1) DEFAULT '0',
  `is_default` tinyint(1) DEFAULT '0',
  `weight` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `room_id` int(11) NOT NULL,
  `registration_id` int(11) NOT NULL,
  `retreatant_id` int(11) NOT NULL,
  `retreat_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `notes` text COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `retreatmasters`
--

CREATE TABLE `retreatmasters` (
  `person_id` bigint(20) UNSIGNED NOT NULL,
  `retreat_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Retreats`
--

CREATE TABLE `Retreats` (
  `Retreat ID` int(11) DEFAULT NULL,
  `Year` int(11) DEFAULT NULL,
  `Retreat Date From` datetime DEFAULT NULL,
  `Retreat Date To` datetime DEFAULT NULL,
  `Retreat Number` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Retreat Name` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `NumberAttended` int(11) DEFAULT NULL,
  `Retreat Master` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Retreat Type ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `retreats`
--

CREATE TABLE `retreats` (
  `id` int(10) UNSIGNED NOT NULL,
  `idnumber` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `start` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `silent` tinyint(1) NOT NULL,
  `amount` decimal(6,2) NOT NULL,
  `year` int(11) NOT NULL,
  `attending` int(11) NOT NULL,
  `directorid` int(11) NOT NULL,
  `innkeeperid` int(11) NOT NULL,
  `assistantid` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `retreat_names`
--

CREATE TABLE `retreat_names` (
  `id` int(4) NOT NULL,
  `title` varchar(52) DEFAULT NULL,
  `start` varchar(16) DEFAULT NULL,
  `end` varchar(16) DEFAULT NULL,
  `idnumber` varchar(4) DEFAULT NULL,
  `ppd_id` varchar(15) DEFAULT NULL,
  `polanco_id` varchar(15) DEFAULT NULL,
  `type` varchar(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rolecaps`
--

CREATE TABLE `rolecaps` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_id` int(11) NOT NULL,
  `capability_id` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `building_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `notes` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `access` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `occupancy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roomstates`
--

CREATE TABLE `roomstates` (
  `id` int(10) UNSIGNED NOT NULL,
  `room_id` int(11) NOT NULL,
  `statechange_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `statusfrom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `statusto` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salutations`
--

CREATE TABLE `salutations` (
  `Salutation ID` int(11) DEFAULT NULL,
  `Salutation Name` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `state_province`
--

CREATE TABLE `state_province` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `abbreviation` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suffix`
--

CREATE TABLE `suffix` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `TABLE 50`
--

CREATE TABLE `TABLE 50` (
  `Retreat ID` int(4) DEFAULT NULL,
  `Year` varchar(4) DEFAULT NULL,
  `Retreat Date From` varchar(10) DEFAULT NULL,
  `Retreat Date To` varchar(10) DEFAULT NULL,
  `Retreat Number` varchar(30) DEFAULT NULL,
  `Retreat Name` varchar(52) DEFAULT NULL,
  `NumberAttended` varchar(3) DEFAULT NULL,
  `Retreat Master` varchar(27) DEFAULT NULL,
  `Retreat Master ID` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `TABLE 110`
--

CREATE TABLE `TABLE 110` (
  `payment_id` int(5) DEFAULT NULL,
  `donation_id` int(5) DEFAULT NULL,
  `payment_amount` decimal(9,2) DEFAULT NULL,
  `payment_date` timestamp NULL DEFAULT NULL,
  `payment_description` varchar(23) DEFAULT NULL,
  `cknumber` varchar(17) DEFAULT NULL,
  `ccnumber` varchar(21) DEFAULT NULL,
  `expire_date` varchar(10) DEFAULT NULL,
  `authorization_number` varchar(8) DEFAULT NULL,
  `note` varchar(100) DEFAULT NULL,
  `ty_letter_sent` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_db2retreats`
--

CREATE TABLE `tmp_db2retreats` (
  `Retreat ID` int(11) DEFAULT NULL,
  `Year` int(11) DEFAULT NULL,
  `Retreat Date From` datetime DEFAULT NULL,
  `Retreat Date To` datetime DEFAULT NULL,
  `Retreat Number` varchar(60) DEFAULT NULL,
  `Retreat Name` varchar(150) DEFAULT NULL,
  `NumberAttended` int(11) DEFAULT NULL,
  `Retreat Master` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_DonorPhoneFix`
--

CREATE TABLE `tmp_DonorPhoneFix` (
  `donor_id` int(11) DEFAULT NULL,
  `FName` varchar(80) CHARACTER SET utf8 DEFAULT NULL,
  `MInitial` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `LName` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `Address` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `Address2` varchar(90) CHARACTER SET utf8 DEFAULT NULL,
  `City` varchar(90) CHARACTER SET utf8 DEFAULT NULL,
  `State` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
  `Zip` varchar(22) CHARACTER SET utf8 DEFAULT NULL,
  `NickName` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `SpouseName` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
  `HomePhone` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
  `WorkPhone` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
  `EMailAddress` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `FaxNumber` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
  `worker_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `phase_id` int(11) DEFAULT NULL,
  `age_id` int(11) DEFAULT NULL,
  `occup_id` int(11) DEFAULT NULL,
  `church_id` int(11) DEFAULT NULL,
  `salut_id` int(11) DEFAULT NULL,
  `NameEnd` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `Gender` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
  `donation_type_id` int(11) DEFAULT NULL,
  `DonationID` int(11) DEFAULT NULL,
  `retreat_id` int(11) DEFAULT NULL,
  `retreat_date` datetime DEFAULT NULL,
  `First Visit` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `Big Donor` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `Old Donor` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `New Date ID` int(11) DEFAULT NULL,
  `NotAvailable` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `Note` varchar(80) CHARACTER SET utf8 DEFAULT NULL,
  `CampLetterSent` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `DateLetSent` datetime DEFAULT NULL,
  `AdventDonor` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `Church` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `Elderhostel` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `Deceased` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `Spouse` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `RoomNum` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
  `Cancel` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `ReqRemoval` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `Note1` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `Note2` text CHARACTER SET utf8,
  `BoardMember` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `NoticeSend` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `Captain` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `Knights` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `CaptainSince` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `ParkCityClub` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `SpeedwayClub` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `DonatedWillNotAttend` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `PartyMailList` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `SpiritDirect` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `KofC Grand Councils` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `Hispanic` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `October Dinner Meeting` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `Board Advisor` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `cell_phone` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `Emergency Contact Num` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `Emergency Name` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `Emergency Contact Num2` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `St Rita Spiritual Exercises` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `sort_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort_name_count` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_donor_sortname_contact`
--

CREATE TABLE `tmp_donor_sortname_contact` (
  `donor_id` int(11) DEFAULT NULL,
  `sort_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `id` int(10) UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_donor_sortname_contact2`
--

CREATE TABLE `tmp_donor_sortname_contact2` (
  `donor_id` int(11) DEFAULT NULL,
  `sort_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `EMailAddress` varchar(100) DEFAULT NULL,
  `Address` varchar(100) DEFAULT NULL,
  `City` varchar(90) DEFAULT NULL,
  `HomePhone` varchar(60) DEFAULT NULL,
  `cell_phone` varchar(100) DEFAULT NULL,
  `id` int(10) UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_dpfixdate`
--

CREATE TABLE `tmp_dpfixdate` (
  `payment_id` int(5) NOT NULL,
  `donation_id` int(5) DEFAULT NULL,
  `payment_amount` decimal(9,2) DEFAULT NULL,
  `payment_date` timestamp NULL DEFAULT NULL,
  `payment_description` varchar(23) DEFAULT NULL,
  `cknumber` varchar(17) DEFAULT NULL,
  `ccnumber` varchar(21) DEFAULT NULL,
  `expire_date` varchar(10) DEFAULT NULL,
  `authorization_number` varchar(8) DEFAULT NULL,
  `note` varchar(100) DEFAULT NULL,
  `ty_letter_sent` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_email`
--

CREATE TABLE `tmp_email` (
  `contact_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_emailable`
--

CREATE TABLE `tmp_emailable` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_event_missing_ppdid`
--

CREATE TABLE `tmp_event_missing_ppdid` (
  `id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `Retreat ID` int(11) DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `idnumber` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'idnumber',
  `Retreat Number` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `touchcategories`
--

CREATE TABLE `touchcategories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `touchpoints`
--

CREATE TABLE `touchpoints` (
  `id` int(10) UNSIGNED NOT NULL,
  `person_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `notes` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `touched_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `touchcategory_id` int(10) UNSIGNED DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Resolved',
  `urgency` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Normal',
  `due_at` timestamp NULL DEFAULT NULL,
  `assignedto_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `userroles`
--

CREATE TABLE `userroles` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'google',
  `provider_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vrmaster`
--

CREATE TABLE `vrmaster` (
  `email_address` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(25) DEFAULT NULL,
  `last_name` varchar(48) DEFAULT NULL,
  `title` varchar(47) DEFAULT NULL,
  `address_1` varchar(66) DEFAULT NULL,
  `address_2` varchar(24) DEFAULT NULL,
  `city` varchar(27) DEFAULT NULL,
  `state` varchar(5) DEFAULT NULL,
  `postalcode` varchar(10) DEFAULT NULL,
  `country` varchar(2) DEFAULT NULL,
  `work_phone` varchar(18) DEFAULT NULL,
  `home_phone` varchar(14) DEFAULT NULL,
  `mobile_phone` varchar(14) DEFAULT NULL,
  `zip` varchar(10) DEFAULT NULL,
  `Suffix` varchar(5) DEFAULT NULL,
  `MiddleName` varchar(15) DEFAULT NULL,
  `Salutation` varchar(29) DEFAULT NULL,
  `Name` varchar(53) DEFAULT NULL,
  `optin_status` varchar(17) DEFAULT NULL,
  `optin_status_last_updated` varchar(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `website`
--

CREATE TABLE `website` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website_type_id` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `website_type` enum('Personal','Work','Main','Facebook','Google','Other','Instagram','LinkedIn','MySpace','Pinterest','SnapChat','Tumblr','Twitter','Vine') COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `UI_source_record_id` (`source_record_id`),
  ADD KEY `UI_activity_type_id` (`activity_type_id`),
  ADD KEY `index_activity_date_time` (`activity_date_time`),
  ADD KEY `index_status_id` (`status_id`),
  ADD KEY `index_medium_id` (`medium_id`),
  ADD KEY `index_is_current_revision` (`is_current_revision`),
  ADD KEY `index_is_deleted` (`is_deleted`),
  ADD KEY `FK_civicrm_activity_phone_id` (`phone_id`),
  ADD KEY `FK_civicrm_activity_parent_id` (`parent_id`),
  ADD KEY `FK_civicrm_activity_relationship_id` (`relationship_id`),
  ADD KEY `FK_civicrm_activity_original_id` (`original_id`),
  ADD KEY `FK_civicrm_activity_campaign_id` (`campaign_id`);

--
-- Indexes for table `activity_contact`
--
ALTER TABLE `activity_contact`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UI_activity_contact` (`contact_id`,`activity_id`,`record_type_id`),
  ADD KEY `index_record_type` (`activity_id`,`record_type_id`);

--
-- Indexes for table `activity_status`
--
ALTER TABLE `activity_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `activity_type`
--
ALTER TABLE `activity_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `address_contact_id_index` (`contact_id`);

--
-- Indexes for table `bu20180209event`
--
ALTER TABLE `bu20180209event`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_ppd_id` (`ppd_id`);

--
-- Indexes for table `bu20180328Donations`
--
ALTER TABLE `bu20180328Donations`
  ADD UNIQUE KEY `idx_donation_id` (`Donation ID`),
  ADD KEY `idx_donor-donation_id` (`Donor ID`,`Donation ID`) USING BTREE;

--
-- Indexes for table `bu20180328Donors`
--
ALTER TABLE `bu20180328Donors`
  ADD UNIQUE KEY `idx_donor_id` (`donor_id`),
  ADD KEY `idx_contact_id` (`contact_id`),
  ADD KEY `idx_sort_name` (`sort_name`) USING BTREE;

--
-- Indexes for table `bu20180402_donations_payment`
--
ALTER TABLE `bu20180402_donations_payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `idx_donation_id` (`donation_id`),
  ADD KEY `payment_date` (`payment_date`);

--
-- Indexes for table `capabilities`
--
ALTER TABLE `capabilities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `captain_retreat`
--
ALTER TABLE `captain_retreat`
  ADD PRIMARY KEY (`contact_id`,`event_id`),
  ADD KEY `captain_retreat_contact_id_index` (`contact_id`),
  ADD KEY `captain_retreat_event_id_index` (`event_id`);

--
-- Indexes for table `civicrm_participant_status_type`
--
ALTER TABLE `civicrm_participant_status_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_sort_name` (`id`),
  ADD KEY `idx_ppd_id` (`ppd_id`);

--
-- Indexes for table `contact_languages`
--
ALTER TABLE `contact_languages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_contact_language` (`contact_id`,`language_id`);

--
-- Indexes for table `contact_referral`
--
ALTER TABLE `contact_referral`
  ADD UNIQUE KEY `contact_referral_contact_id_referral_id_unique` (`contact_id`,`referral_id`);

--
-- Indexes for table `contact_type`
--
ALTER TABLE `contact_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contribution`
--
ALTER TABLE `contribution`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UI_contrib_trxn_id` (`trxn_id`),
  ADD UNIQUE KEY `UI_contrib_invoice_id` (`invoice_id`),
  ADD KEY `UI_contrib_payment_instrument_id` (`payment_instrument_id`),
  ADD KEY `index_contribution_status` (`contribution_status_id`),
  ADD KEY `received_date` (`receive_date`),
  ADD KEY `check_number` (`check_number`),
  ADD KEY `contribution_contact_id_foreign` (`contact_id`),
  ADD KEY `contribution_honor_type_id_foreign` (`honor_type_id`),
  ADD KEY `contribution_address_id_foreign` (`address_id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `county`
--
ALTER TABLE `county`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dioceses`
--
ALTER TABLE `dioceses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `domain`
--
ALTER TABLE `domain`
  ADD PRIMARY KEY (`id`),
  ADD KEY `domain_contact_id_foreign` (`contact_id`),
  ADD KEY `UI_name` (`name`);

--
-- Indexes for table `Donations`
--
ALTER TABLE `Donations`
  ADD PRIMARY KEY (`donation_id`),
  ADD UNIQUE KEY `idx_donation_id` (`donation_id`),
  ADD KEY `idx_donor-donation_id` (`donor_id`,`donation_id`) USING BTREE,
  ADD KEY `ppd_id` (`ppd_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `Donations_payment`
--
ALTER TABLE `Donations_payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `idx_donation_id` (`donation_id`),
  ADD KEY `payment_date` (`payment_date`);

--
-- Indexes for table `donation_type`
--
ALTER TABLE `donation_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Donors`
--
ALTER TABLE `Donors`
  ADD UNIQUE KEY `idx_donor_id` (`donor_id`),
  ADD KEY `idx_contact_id` (`contact_id`),
  ADD KEY `idx_sort_name` (`sort_name`) USING BTREE;

--
-- Indexes for table `email`
--
ALTER TABLE `email`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email_contact_id_index` (`contact_id`);

--
-- Indexes for table `emergency_contact`
--
ALTER TABLE `emergency_contact`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_contact_id` (`contact_id`),
  ADD KEY `idx_name` (`name`),
  ADD KEY `idx_relationship` (`relationship`),
  ADD KEY `idx_phone` (`phone`),
  ADD KEY `idx_phone_alternate` (`phone_alternate`);

--
-- Indexes for table `ethnicities`
--
ALTER TABLE `ethnicities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_ppd_id` (`ppd_id`);

--
-- Indexes for table `event_type`
--
ALTER TABLE `event_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `file`
--
ALTER TABLE `file`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_file_type_id` (`file_type_id`),
  ADD KEY `idx_entity_id` (`entity`,`entity_id`),
  ADD KEY `idx_uri` (`uri`),
  ADD KEY `idx_description` (`description`);

--
-- Indexes for table `file_type`
--
ALTER TABLE `file_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `financial_account`
--
ALTER TABLE `financial_account`
  ADD PRIMARY KEY (`id`),
  ADD KEY `financial_account_contact_id_foreign` (`contact_id`),
  ADD KEY `financial_account_parent_id_foreign` (`parent_id`),
  ADD KEY `UI_name` (`name`);

--
-- Indexes for table `financial_trxn`
--
ALTER TABLE `financial_trxn`
  ADD PRIMARY KEY (`id`),
  ADD KEY `financial_trxn_from_financial_account_id_foreign` (`from_financial_account_id`),
  ADD KEY `financial_trxn_to_financial_account_id_foreign` (`to_financial_account_id`),
  ADD KEY `UI_ftrxn_payment_instrument_id` (`payment_processor_id`),
  ADD KEY `UI_ftrxn_check_number` (`check_number`);

--
-- Indexes for table `gender`
--
ALTER TABLE `gender`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group`
--
ALTER TABLE `group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group_contact`
--
ALTER TABLE `group_contact`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_group_contact` (`group_id`,`contact_id`);

--
-- Indexes for table `jesuits`
--
ALTER TABLE `jesuits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_reserved_at_index` (`queue`,`reserved_at`);

--
-- Indexes for table `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `locations_name_unique` (`name`);

--
-- Indexes for table `location_type`
--
ALTER TABLE `location_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `messages_mailgun_id_unique` (`mailgun_id`);

--
-- Indexes for table `message_attachments`
--
ALTER TABLE `message_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `message_attachments_mailgun_id_index` (`mailgun_id`);

--
-- Indexes for table `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_entity_id` (`entity_table`,`entity_id`),
  ADD KEY `idx_note` (`note`(512)),
  ADD KEY `idx_subject` (`subject`);

--
-- Indexes for table `parishes`
--
ALTER TABLE `parishes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `participant`
--
ALTER TABLE `participant`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_donation_id` (`donation_id`),
  ADD KEY `idx_contact` (`contact_id`),
  ADD KEY `idx_event` (`event_id`);

--
-- Indexes for table `participant_payment`
--
ALTER TABLE `participant_payment`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UI_contribution_participant` (`contribution_id`,`participant_id`),
  ADD KEY `participant_payment_participant_id_foreign` (`participant_id`);

--
-- Indexes for table `participant_role_type`
--
ALTER TABLE `participant_role_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `participant_status_type`
--
ALTER TABLE `participant_status_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `payment_processor`
--
ALTER TABLE `payment_processor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `UI_name_test_domain_id` (`name`,`is_test`,`domain_id`),
  ADD KEY `payment_processor_payment_processor_type_id_foreign` (`payment_processor_type_id`);

--
-- Indexes for table `payment_processor_type`
--
ALTER TABLE `payment_processor_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `UI_name` (`name`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`);

--
-- Indexes for table `persons`
--
ALTER TABLE `persons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `persons_email_unique` (`email`),
  ADD UNIQUE KEY `persons_donor_id_unique` (`donor_id`);

--
-- Indexes for table `phone`
--
ALTER TABLE `phone`
  ADD PRIMARY KEY (`id`),
  ADD KEY `phone_contact_id_index` (`contact_id`);

--
-- Indexes for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pma__central_columns`
--
ALTER TABLE `pma__central_columns`
  ADD PRIMARY KEY (`db_name`,`col_name`);

--
-- Indexes for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `db_name` (`db_name`,`table_name`,`column_name`);

--
-- Indexes for table `pma__designer_settings`
--
ALTER TABLE `pma__designer_settings`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_user_type_template` (`username`,`export_type`,`template_name`);

--
-- Indexes for table `pma__favorite`
--
ALTER TABLE `pma__favorite`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__history`
--
ALTER TABLE `pma__history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`,`db`,`table`,`timevalue`);

--
-- Indexes for table `pma__navigationhiding`
--
ALTER TABLE `pma__navigationhiding`
  ADD PRIMARY KEY (`username`,`item_name`,`item_type`,`db_name`,`table_name`);

--
-- Indexes for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  ADD PRIMARY KEY (`page_nr`),
  ADD KEY `db_name` (`db_name`);

--
-- Indexes for table `pma__recent`
--
ALTER TABLE `pma__recent`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__relation`
--
ALTER TABLE `pma__relation`
  ADD PRIMARY KEY (`master_db`,`master_table`,`master_field`),
  ADD KEY `foreign_field` (`foreign_db`,`foreign_table`);

--
-- Indexes for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_savedsearches_username_dbname` (`username`,`db_name`,`search_name`);

--
-- Indexes for table `pma__table_coords`
--
ALTER TABLE `pma__table_coords`
  ADD PRIMARY KEY (`db_name`,`table_name`,`pdf_page_number`);

--
-- Indexes for table `pma__table_info`
--
ALTER TABLE `pma__table_info`
  ADD PRIMARY KEY (`db_name`,`table_name`);

--
-- Indexes for table `pma__table_uiprefs`
--
ALTER TABLE `pma__table_uiprefs`
  ADD PRIMARY KEY (`username`,`db_name`,`table_name`);

--
-- Indexes for table `pma__tracking`
--
ALTER TABLE `pma__tracking`
  ADD PRIMARY KEY (`db_name`,`table_name`,`version`);

--
-- Indexes for table `pma__userconfig`
--
ALTER TABLE `pma__userconfig`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__usergroups`
--
ALTER TABLE `pma__usergroups`
  ADD PRIMARY KEY (`usergroup`,`tab`,`allowed`);

--
-- Indexes for table `pma__users`
--
ALTER TABLE `pma__users`
  ADD PRIMARY KEY (`username`,`usergroup`);

--
-- Indexes for table `ppd_occupations`
--
ALTER TABLE `ppd_occupations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prefix`
--
ALTER TABLE `prefix`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `referral`
--
ALTER TABLE `referral`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `relationship`
--
ALTER TABLE `relationship`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_contact_a` (`contact_id_a`),
  ADD KEY `idx_contact_b` (`contact_id_b`);

--
-- Indexes for table `relationship_type`
--
ALTER TABLE `relationship_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `religion`
--
ALTER TABLE `religion`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `retreatmasters`
--
ALTER TABLE `retreatmasters`
  ADD PRIMARY KEY (`person_id`,`retreat_id`),
  ADD KEY `retreatmasters_person_id_index` (`person_id`),
  ADD KEY `retreatmasters_retreat_id_index` (`retreat_id`);

--
-- Indexes for table `Retreats`
--
ALTER TABLE `Retreats`
  ADD UNIQUE KEY `idx_retreat_id` (`Retreat ID`),
  ADD KEY `idx_retreat_number` (`Retreat Number`);

--
-- Indexes for table `retreats`
--
ALTER TABLE `retreats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `retreat_names`
--
ALTER TABLE `retreat_names`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_ppdid` (`ppd_id`),
  ADD UNIQUE KEY `idx_polanco_id` (`polanco_id`);

--
-- Indexes for table `rolecaps`
--
ALTER TABLE `rolecaps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `role_user_role_id_foreign` (`role_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roomstates`
--
ALTER TABLE `roomstates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `state_province`
--
ALTER TABLE `state_province`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suffix`
--
ALTER TABLE `suffix`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tmp_db2retreats`
--
ALTER TABLE `tmp_db2retreats`
  ADD KEY `idx_id` (`Retreat ID`);

--
-- Indexes for table `tmp_DonorPhoneFix`
--
ALTER TABLE `tmp_DonorPhoneFix`
  ADD UNIQUE KEY `idx_donor_id` (`donor_id`),
  ADD KEY `idx_contact_id` (`contact_id`),
  ADD KEY `idx_sort_name` (`sort_name`) USING BTREE;

--
-- Indexes for table `tmp_dpfixdate`
--
ALTER TABLE `tmp_dpfixdate`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `tmp_emailable`
--
ALTER TABLE `tmp_emailable`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `touchcategories`
--
ALTER TABLE `touchcategories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `touchpoints`
--
ALTER TABLE `touchpoints`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userroles`
--
ALTER TABLE `userroles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_provider_id_unique` (`provider_id`);

--
-- Indexes for table `vrmaster`
--
ALTER TABLE `vrmaster`
  ADD PRIMARY KEY (`email_address`),
  ADD KEY `email_address` (`email_address`);

--
-- Indexes for table `website`
--
ALTER TABLE `website`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_contact_id` (`contact_id`),
  ADD KEY `idx_url` (`url`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Unique  Other Activity ID';
--
-- AUTO_INCREMENT for table `activity_contact`
--
ALTER TABLE `activity_contact`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Activity contact id';
--
-- AUTO_INCREMENT for table `activity_status`
--
ALTER TABLE `activity_status`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `activity_type`
--
ALTER TABLE `activity_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47614;
--
-- AUTO_INCREMENT for table `bu20180209event`
--
ALTER TABLE `bu20180209event`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4089;
--
-- AUTO_INCREMENT for table `capabilities`
--
ALTER TABLE `capabilities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `civicrm_participant_status_type`
--
ALTER TABLE `civicrm_participant_status_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'unique participant status type id', AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24097;
--
-- AUTO_INCREMENT for table `contact_languages`
--
ALTER TABLE `contact_languages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3927;
--
-- AUTO_INCREMENT for table `contact_type`
--
ALTER TABLE `contact_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `contribution`
--
ALTER TABLE `contribution`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1254;
--
-- AUTO_INCREMENT for table `county`
--
ALTER TABLE `county`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `dioceses`
--
ALTER TABLE `dioceses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `domain`
--
ALTER TABLE `domain`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Donations`
--
ALTER TABLE `Donations`
  MODIFY `donation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62036;
--
-- AUTO_INCREMENT for table `Donations_payment`
--
ALTER TABLE `Donations_payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84707;
--
-- AUTO_INCREMENT for table `donation_type`
--
ALTER TABLE `donation_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;
--
-- AUTO_INCREMENT for table `email`
--
ALTER TABLE `email`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34010;
--
-- AUTO_INCREMENT for table `emergency_contact`
--
ALTER TABLE `emergency_contact`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23134;
--
-- AUTO_INCREMENT for table `ethnicities`
--
ALTER TABLE `ethnicities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4218;
--
-- AUTO_INCREMENT for table `event_type`
--
ALTER TABLE `event_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `file`
--
ALTER TABLE `file`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2521;
--
-- AUTO_INCREMENT for table `file_type`
--
ALTER TABLE `file_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `financial_account`
--
ALTER TABLE `financial_account`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `financial_trxn`
--
ALTER TABLE `financial_trxn`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gender`
--
ALTER TABLE `gender`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `group`
--
ALTER TABLE `group`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `group_contact`
--
ALTER TABLE `group_contact`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1261;
--
-- AUTO_INCREMENT for table `jesuits`
--
ALTER TABLE `jesuits`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `language`
--
ALTER TABLE `language`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=194;
--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `location_type`
--
ALTER TABLE `location_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `message_attachments`
--
ALTER TABLE `message_attachments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `note`
--
ALTER TABLE `note`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8722;
--
-- AUTO_INCREMENT for table `parishes`
--
ALTER TABLE `parishes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=239;
--
-- AUTO_INCREMENT for table `participant`
--
ALTER TABLE `participant`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154928;
--
-- AUTO_INCREMENT for table `participant_payment`
--
ALTER TABLE `participant_payment`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `participant_role_type`
--
ALTER TABLE `participant_role_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `participant_status_type`
--
ALTER TABLE `participant_status_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `payment_processor`
--
ALTER TABLE `payment_processor`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `payment_processor_type`
--
ALTER TABLE `payment_processor_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;
--
-- AUTO_INCREMENT for table `persons`
--
ALTER TABLE `persons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=488;
--
-- AUTO_INCREMENT for table `phone`
--
ALTER TABLE `phone`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161491;
--
-- AUTO_INCREMENT for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pma__history`
--
ALTER TABLE `pma__history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  MODIFY `page_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ppd_occupations`
--
ALTER TABLE `ppd_occupations`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=334;
--
-- AUTO_INCREMENT for table `prefix`
--
ALTER TABLE `prefix`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `referral`
--
ALTER TABLE `referral`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=239;
--
-- AUTO_INCREMENT for table `relationship`
--
ALTER TABLE `relationship`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10696;
--
-- AUTO_INCREMENT for table `relationship_type`
--
ALTER TABLE `relationship_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `religion`
--
ALTER TABLE `religion`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `retreats`
--
ALTER TABLE `retreats`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1419;
--
-- AUTO_INCREMENT for table `rolecaps`
--
ALTER TABLE `rolecaps`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;
--
-- AUTO_INCREMENT for table `roomstates`
--
ALTER TABLE `roomstates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `state_province`
--
ALTER TABLE `state_province`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10269;
--
-- AUTO_INCREMENT for table `suffix`
--
ALTER TABLE `suffix`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
--
-- AUTO_INCREMENT for table `touchcategories`
--
ALTER TABLE `touchcategories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `touchpoints`
--
ALTER TABLE `touchpoints`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10865;
--
-- AUTO_INCREMENT for table `userroles`
--
ALTER TABLE `userroles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
--
-- AUTO_INCREMENT for table `website`
--
ALTER TABLE `website`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36210;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `captain_retreat`
--
ALTER TABLE `captain_retreat`
  ADD CONSTRAINT `captain_retreat_contact_id_foreign` FOREIGN KEY (`contact_id`) REFERENCES `contact` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `captain_retreat_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `contribution`
--
ALTER TABLE `contribution`
  ADD CONSTRAINT `contribution_address_id_foreign` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`),
  ADD CONSTRAINT `contribution_contact_id_foreign` FOREIGN KEY (`contact_id`) REFERENCES `contact` (`id`),
  ADD CONSTRAINT `contribution_honor_type_id_foreign` FOREIGN KEY (`honor_type_id`) REFERENCES `contact` (`id`);

--
-- Constraints for table `domain`
--
ALTER TABLE `domain`
  ADD CONSTRAINT `domain_contact_id_foreign` FOREIGN KEY (`contact_id`) REFERENCES `contact` (`id`);

--
-- Constraints for table `financial_account`
--
ALTER TABLE `financial_account`
  ADD CONSTRAINT `financial_account_contact_id_foreign` FOREIGN KEY (`contact_id`) REFERENCES `contact` (`id`),
  ADD CONSTRAINT `financial_account_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `financial_account` (`id`);

--
-- Constraints for table `financial_trxn`
--
ALTER TABLE `financial_trxn`
  ADD CONSTRAINT `financial_trxn_from_financial_account_id_foreign` FOREIGN KEY (`from_financial_account_id`) REFERENCES `financial_account` (`id`),
  ADD CONSTRAINT `financial_trxn_payment_processor_id_foreign` FOREIGN KEY (`payment_processor_id`) REFERENCES `payment_processor` (`id`),
  ADD CONSTRAINT `financial_trxn_to_financial_account_id_foreign` FOREIGN KEY (`to_financial_account_id`) REFERENCES `financial_account` (`id`);

--
-- Constraints for table `participant_payment`
--
ALTER TABLE `participant_payment`
  ADD CONSTRAINT `participant_payment_contribution_id_foreign` FOREIGN KEY (`contribution_id`) REFERENCES `contribution` (`id`),
  ADD CONSTRAINT `participant_payment_participant_id_foreign` FOREIGN KEY (`participant_id`) REFERENCES `participant` (`id`);

--
-- Constraints for table `payment_processor`
--
ALTER TABLE `payment_processor`
  ADD CONSTRAINT `payment_processor_payment_processor_type_id_foreign` FOREIGN KEY (`payment_processor_type_id`) REFERENCES `payment_processor_type` (`id`);

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
