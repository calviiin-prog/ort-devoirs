public class Main {
	public static void main(String[] args) {
		
		String[] words = {"bateau","kayak","piston","voiture","analphab�te","superviser","empereur","proteine","cable","cabat","pistache","bombarde"};
		boolean change = true;
		String[] tmplist = new String[2];
		
		while (change) {
			change = false;
			
			for (int indice = 0 ; indice < words.length-1 ; indice++ ) {
				tmplist = setOrder(words[indice] ,words[indice+1] );
				if (tmplist[0].equals(words[indice+1]) ) {
					words[indice] = tmplist[0]; words[indice+1] = tmplist[1];
					change = true;
				}
			}
		}
		
		for (String wordprintable : words) {
			System.out.println(wordprintable);
		}
	}
	
	public static String[] setOrder(String word1 , String word2 ) {
		
		char[] alphaorder = { '-',' ','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'};
		String[] twoorder = new String[2];
		int maxcount, iword1 = 0, iword2 = 0 ;
		
		if (word1.length() > word2.length()) {
			maxcount = word2.length();
		}
		else {
			maxcount = word1.length();
		}
		for (int i = 0 ; i < maxcount ; i++) {
			//Verification des lettres de l'alphabet
			for (int z = 0;z < alphaorder.length;z++ ) {
				if (word1.toLowerCase().charAt(i) == alphaorder[z] ) {
					iword1 = z;
				}
				if (word2.toLowerCase().charAt(i) == alphaorder[z] ) {
					iword2 = z;
			}
		}
			//Retour dans l'ordre
			if (iword1 != iword2) {
				if (iword1 > iword2) {
					twoorder[0] = word2; twoorder[1] = word1; 
				}
				else if (iword2 > iword1) {
					twoorder[0] = word1; twoorder[1] = word2; 
				}
				return twoorder;
			}
			//Retour des mots plus court 
			else if (iword1 == iword2 && i == maxcount-1) {
				if (word1.length() < word2.length()) {
					twoorder[0] = word1; twoorder[1] = word2;
				}
				if (word2.length() < word1.length()) {
					twoorder[0] = word2; twoorder[1] = word1;
				}
				return twoorder;
			}
		}
		return twoorder;
	}
}

