<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Constant
{
   const PAGE_SIZE = 1000;
   const ANNOUNCEMENT_SIZE = 20;

   //User general action constants
   const CREATE = 'create';
   const UPDATE = 'update';
   const DELETE = 'delete';

   //User specific action constants
  const HITSUY = 'hitsuy';
  const CORE_DEGEFTI = 'coreDegefti';
  const TRANSFER = 'transfer';
  const MIDEBA  = 'mideba';
   const SRIRIE_WOREDA = 'sririeWoreda';
   const SRIRIE_WIDABE = 'sririeWidabe';
   const SRIRIE_WAHIO = 'sririeWahio';
   const PLAN_WIDABE = 'planWidabe';
   const PLAN_WAHIO = 'planWahio';
   const PLAN_INDIVIDUAL = 'planIndividual';

   const ACTION_MAP = [
    Constant::HITSUY => 'ሕፁይ',
    Constant::CORE_DEGEFTI => 'ቀወምቲ ደገፍቲ',
    Constant::TRANSFER => 'ዝውውር',
    Constant::MIDEBA => 'ምደባ',
    Constant::SRIRIE_WOREDA => 'ስርርዕ ወረዳ',
    Constant::SRIRIE_WIDABE => 'ስርርዕ ውዳበ',
	Constant::SRIRIE_WAHIO => 'ስርርዕ ዋህዮ',
	constant::PLAN_WIDABE => 'ትልሚ ውዳበ',
    constant::PLAN_WAHIO => 'ትልሚ ዋህዮ',
    constant::PLAN_INDIVIDUAL => 'ትልሚ ውልቀ ሰብ'
   ];

    
}
