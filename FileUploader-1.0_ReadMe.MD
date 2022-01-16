# FileUploader_Class

-----------------------------------------------------------------------------------------------------------
#Bu Kütüphane nasıl kullanılır ?

##Tek Dosya yüklemek için kullanılan bir kütüphane
yani input eteketi multiple özelline sahip olmamalı ve bununla beraber name attribute dizi değeri <b>içermemeli</b> 
(name="photo" (doğuru) , name="photo[]" (yalnış))

kabul edilen uzantılar :
pdf , jpg , jpeg , docx , pptx (Class içersinde bulunan allowedExtenssions dizisinden değiştirebilirsiniz) .

kullanış yöntemi :
name="photo" özelliğine sahip olan bir input eteketimiz olsun :
php sayfasına şöyle gönderilecek $_FILES["photo"]

FileUploader bir nesnesini oluşturup ve nesneye $_FILES["photo"] verilir , aşağıdaki gibi :
$fileUploader = new FileUploader($_FILES["photoes"]);

<b>getSet_fianlFileName</b> metedu ile dosyanın yeni ismini elde edilir ...... yalnız onu kullanırken ona iki değer verilmeli :
1 - Dosyanın taşınacağı Klasörün yolu (path).
2 - Dosyanın yeni ismine eklenmek istenen yazı (örnek : "Tez_File_" , "personel_photo").

Ve yükleme işlemi tamamlamak için <b>uploadFile</b> Metedounu kullanılır (true yada false ile geri dönüş yapar) .
 
yükleme işlemi tamamlanmadıysa getErrorMessages() metedunu kullanıp Yükleme hatalarının dizisini elde edebilirsiniz .

----------
örnek :
    $fileUploader = new FileUploader($_FILES["photo"]);
    $fileUploader->getSet_fianlFileName("./testFolder/" , "FILE_");
    $fileUploader->uploadFile();
    
    Çıkış :
      uploadFile Metedodu Yüklenen Dosya (photo) testFolder klasörüne yükleyeip true ile dönüş yapacaktır 
      
    $fileUploader->getErrorMessages() : ile Yükleme hatalarının dizisini elde edebilirsiniz .
----------

facebook üzerinden bana destekçi olmayı unutmayın ....... Teşekkürler https://www.facebook.com/MDRDevelopment

-----------------------------------------------------------------------------------------------------------
#طريقة الاستخدام بالعربية

يمكنك استخدام هذه المكتبة لرفع ملف واحد فقط 

أي لدينا شرطان لإمكانية استخدام هذه المكتبة :
1- اسم الحقل مفرد وليس مصفوفة
2 - خاصية تعدد الاختيار غير مُفعلة

استخدامك لهذه المكتبة يسمح لك برفع الملف بكتابة ثلاثة أسطر من الكود فقط وذلك دون الإخلال بعمليات التحقق من لاحقة الملف
يمكنك رفع ملفات بامتدادات :
pdf , jpg , jpeg , docx , pptx

طريقة الاستخدام :
لنفرض أن لدينا حقل لرفع ملف يحمل السمة التالية 
name="photo"
قم بإنشاء كائن من الكلاس ومرر له القيمة 

$_FILES["photo"]

استخدام الوظيفة :
getSet_fianlFileName
ومرر لها القيم التالية 
1- مسار الجلد المُراد نقل الملف إليه
2- لاحقة نصية تودُ إضافتها لاسم الملف بعد تغيير اسمه
في حال نجاح العملية ستُرجع الوظيفة اسم الملف لتتمكن من تخزينه في قاعدة البيانات وفي حال الفشل سترجع
null

في النهاية استخدم الوظيفة
uploadFile
لإنهاء عملية رفع الملف وناتج هذه الدالة هو ناتج منطقي


getErrorMessages()
    عبر هذه الدالة نحصل على مصفوفة الأخطاء الناتج عنها فشل عملية رفع الملف (في حال حدث ذلك) 

----------
مثال
    $fileUploader = new FileUploader($_FILES["photo"]);
    $fileUploader->getSet_fianlFileName("./testFolder/" , "FILE_");
    $fileUploader->uploadFile();
    
    الناتج سيكون
      سيتم رفع الملف 
      photo
      عبر الوظيفة
      uploadFile
      إلى المجلد 
      testFoler
      
    $fileUploader->getErrorMessages()
    عبر هذه الدالة نحصل على مصفوفة الأخطاء الناتج عنها فشل عملية رفع الملف (في حال حدث ذلك) 
----------

لا ننسوا دعمي على الفيسبوك
https://www.facebook.com/MDRDevelopment
--------------------------------------------------------------------------------------------------------- 
