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
			$im->setResolution(500, 500);
			
			$im->readImage(pdf_dir."$value");

			echo "Чтение файла: $value - завершено.\n";

			for ($i = 0; $i < $im->getNumberImages(); $i++)
			{
				$im->previousImage();
				echo "Следующий лист файла: $value.\n";

				echo "Запись файла: $img_name-$i.jpg.\n";

		        $im->setImageFormat('jpeg');

		        if (!is_dir(__DIR__."/$value/"))
		        	mkdir(__DIR__."/$value/");

		        $im->writeImage(__DIR__."/$value/$img_name-$i.jpg");
				echo "Запись файла: $img_name-$i.jpg завершена.\n";
		    }
			
			echo "Обработка файла: $value - завершена.\n";
			$im->clear(); 
		}
	}

	echo "Обработка файов директории: ".pdf_dir." - завершена.\n";

	$im->destroy();