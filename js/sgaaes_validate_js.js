function validalogin(){
	if(frmlogin.txtusuario.value == ''){
		alert('O campo nome de usuário deve ser preenchido!');
		frmlogin.txtusuario.focus();
		return false;
	}else if(frmlogin.pwdsenha.value == ''){
				alert('O campo senha deve ser preenchido');
				frmlogin.pwdsenha.focus();
				return false;
			}else{
				return true;
			}
}

function validaregistroaluno(){
	if(frmrgtstudent.txtnomecompleto.value == ''){
		alert('O campo nome completo deve ser preenchido!');
		frmrgtstudent.txtnomecompleto.focus();
		return false;
	}else if(frmrgtstudent.txtepiteto.value == ''){
				alert('O campo epiteto deve ser preenchido!');
				frmrgtstudent.txtepiteto.focus();
				return false;
			}else if(frmrgtstudent.selturma.value == ''){
						alert('É necessário selecionar uma turma!');
						frmrgtstudent.selturma.focus();
						return false;
					}else if(frmrgtstudent.txtemail.value == ''){
								alert('O campo e-mail deve ser preenchido!');
								frmrgtstudent.txtemail.focus();
								return false;
							}else if(frmrgtstudent.txtusuario.value == ''){
										alert('O campo usuário deve ser preenchido!');
										frmrgtstudent.txtusuario.focus();
										return false;
									}else{
										return true;
									}
}

function validaregistroturma(){
	if(frmrgtclass.txtnometurma.value == ''){
		alert('O campo nome da turma deve ser preenchido!');
		frmrgtclass.txtnometurma.focus();
		return false;
	}else if(frmrgtclass.selmodalidade.value == ''){
				alert('É necessário selecionar uma modalidade!');
				frmrgtclass.selmodalidade.focus();
				return false;
			}else if(frmrgtclass.selperiodo.value == ''){
						alert('É necessário selecionar um período!');
						frmrgtclass.selperiodo.focus();
						return false;
					}else{
						return true;
					}
}

function deletar(pr_tipo,pr_nome){
	return confirm("você realmente deseja excluir "+pr_tipo+" "+pr_nome);
}