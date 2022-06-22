<?php
	const pdf_dir = __DIR__."/../pdf/";

	$im = new Imagick();

	$scan = scandir(pdf_dir);

	foreach ($scan as $value) {
		if (is_file(pdf_dir.$value))
		{
			$exp = explode(".", $value);
			$img_name = $exp[0];
			$upload_dir = $exp[1];
			
			echo "Чтение файла: $value.\n";

			$im->setResolution(300, 300);

			$im->readImage(pdf_dir."$value");

			echo "Чтение файла: $value - завершено.\n";

			for ($i = 0; $i < $im->getNumberImages(); $i++)
			{
				$im->previousImage();
				echo "Следующий лист файла: $value.\n";

				echo "Запись файла: $img_name-$i.png.\n";

		        $im->setImageFormat('png');

		        if (!is_dir(__DIR__."/$value/"))
		        	mkdir(__DIR__."/$value/");
		        $im->setBackgroundColor(new ImagickPixel('#ffffff'));
		        $im->setImageAlphaChannel($im::ALPHACHANNEL_REMOVE);

		        $im->setImageCompressionQuality(95);
		        $im->resizeImage($im->getImageWidth()/1.25, $im->getImageHeight()/1.25, null, 0);

		        $im->writeImage(__DIR__."/$value/$img_name-$i.png");
				echo "Запись файла: $img_name-$i.png завершена.\n";
		    }
			
			echo "Обработка файла: $value - завершена.\n";
			$im->clear(); 
		break;

		}
	}

	echo "Обработка файов директории: ".pdf_dir." - завершена.\n";

	$im->destroy();